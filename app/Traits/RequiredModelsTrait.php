<?php
namespace App\Traits;

use App\Constants\SurveyConstants;
use App\Http\Resources\RequiredAchievementResource;
use App\Http\Resources\RequiredContentResource;
use App\Http\Resources\RequiredCubeResource;
use App\Http\Resources\RequiredSectionResource;
use App\Http\Resources\RequiredSurveyResource;
use App\Models\Achievement;
use App\Models\AchievementUser;
use App\Models\Content;
use App\Models\ContentUser;
use App\Models\Cube;
use App\Models\CubeUser;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Section;
use App\Models\Survey;
use App\Models\SurveyUser;
use Carbon\Carbon;

trait RequiredModelsTrait
{
    public function checkAvailableFrom($date = false, $time = false, $model)
    {
        $currentTimestamp = Carbon::now();
        $nowDate = $currentTimestamp->format('Y-m-d');
        $nowTime = $currentTimestamp->format('H:i:s');
        $availableFrom = Carbon::parse($model->available_from);
        $state = true;

        if ($date) {
            if ($nowDate < $availableFrom->format('Y-m-d')) {
                $state = false;
            }
        } else if ($date && $time) {
            if ($nowDate > $availableFrom->format('Y-m-d')) {
                $state = false;
            }
        }

        return $state;
    }

    public function checkDeadLine($date = false, $time = false, $model)
    {
        $currentTimestamp = Carbon::now();
        $nowDate = $currentTimestamp->format('Y-m-d');
        $nowTime = $currentTimestamp->format('H:i:s');
        $state = true;

        if ($date) {
            if ($nowDate > $model->deadline_date) {
                $state = false;
            }
        } else if ($date && $time) {
            if ($nowDate > $model->deadline_date) {
                $state = false;
            } else if ($nowDate == $model->deadline_date) {
                if ($nowTime > $model->deadline_time) {
                    $state = false;
                }
            }
        }

        return $state;
    }

    public function checkRequiredCubes($user, $requiredCubes)
    {
        $canStart = false;
        $userFinishedCubes = $user->cubesByIds($requiredCubes)
            ->wherePivot('finished_at', '!=', null)
            ->get();
        $userFinishedCubesIds = $userFinishedCubes->pluck('id')->toArray();

        $unfinishedCubeIds = array_diff($requiredCubes, $userFinishedCubesIds);
        if ($unfinishedCubeIds) {
            $unfinishedCubes = Cube::whereIn('id', $unfinishedCubeIds)->get();
            $unfinishedCubes = RequiredCubeResource::collection($unfinishedCubes);
            return $unfinishedCubes;
        }else{
            return collect();
        }
    }

    public function checkRequiredQuizzes($user, $requiredQuizzes)
    {
        $canStart = false;
        $userFinishedQuizs = $user->quizzesByIds($requiredQuizzes)
            ->wherePivot('finished_at', '!=', null)
            ->get();

        $userFinishedQuizsIds = $userFinishedQuizs->pluck('id')->toArray();

        $unfinishedQuizzesIds = array_diff($requiredQuizzes, $userFinishedQuizsIds);
        if ($unfinishedQuizzesIds) {
            $unfinishedQuizzes = Quiz::whereIn('id', $unfinishedQuizzesIds)->get();
            $unfinishedQuizzes = RequiredContentResource::collection($unfinishedQuizzes);
            return $unfinishedQuizzes;
        }else{
            return collect();
        }
    }

    public function checkRequiredSections($user, $requiredSections)
    {
        $userFinishedSections = $user->sectionsByIds($requiredSections)
            ->wherePivot('finished_at', '!=', null)
            ->get();

        $userFinishedSectionsIds = $userFinishedSections->pluck('id')->toArray();

        $unfinishedSectionIds = array_diff($requiredSections, $userFinishedSectionsIds);
        if ($unfinishedSectionIds) {
            $unfinishedSections = Section::whereIn('id', $unfinishedSectionIds)->get();
            $unfinishedSections = RequiredSectionResource::collection($unfinishedSections);
            return $unfinishedSections;
        }else{
            return collect();
        }

    }

    public function checkRequiredContents($user, $requiredContents)
    {
        $userFinishedContents = $user->contentsByIds($requiredContents)
            ->wherePivot('finished_at', '!=', null)
            ->get();

        $userFinishedContentsIds = $userFinishedContents->pluck('id')->toArray();

        $unFinishedContentsIds = array_diff($requiredContents, $userFinishedContentsIds);

        if ($unFinishedContentsIds) {
            $unfinishedContents = Content::whereIn('id', $unFinishedContentsIds)->get();
            $unfinishedContents = RequiredContentResource::collection($unfinishedContents);
            return $unfinishedContents;
        }else{
            return collect();
        }
    }

    public function checkRequiredAchievements($user, $requiredAchievements)
    {
        $userFinishedAchievements = $user->achievementsByIds($requiredAchievements)
            ->wherePivot('finished_at', '!=', null)
            ->get();
        $userFinishedAchievementsIds = $userFinishedAchievements->pluck('id')->toArray();

        $unFinishedAchievementsIds = array_diff($requiredAchievements, $userFinishedAchievementsIds);

        if ($unFinishedAchievementsIds) {
            $unfinishedAchievements = Achievement::whereIn('id', $unFinishedAchievementsIds)->get();
            $unfinishedAchievements = RequiredAchievementResource::collection($unfinishedAchievements);
            return $unfinishedAchievements;
        }else{
            return collect();
        }

    }

    public function checkRequiredSurveys($user, $requiredSurveys)
    {
        $userFinishedSurveys = $user->surveysByIds($requiredSurveys)
            ->wherePivot('finished_at', '!=', null)
            ->get();
        $userFinishedSurveysIds = $userFinishedSurveys->pluck('id')->toArray();

        $unFinishedSurveysIds = array_diff($requiredSurveys, $userFinishedSurveysIds);

        if ($unFinishedSurveysIds) {
            $unfinishedSurveys = Survey::whereIn('id', $unFinishedSurveysIds)->get();
            $unfinishedSurveys = RequiredSurveyResource::collection($unfinishedSurveys);
            return $unfinishedSurveys;
        }else{
            return collect();
        }
    }

}
