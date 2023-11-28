<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EvaluationAnswer;
use App\Models\Evaluation;
use App\Models\EvaluationSubject;
use App\Models\EvaluationItem;
use App\Models\StudyLevel;
use App\Models\Subject;
use App\Models\SubjectStudyLevel;
use App\Models\Theme;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EvaluationAnswer>
 */
class EvaluationAnswerFactory extends Factory
{
    private $index = 0;
    public function definition(): array
    {

        $answers = [
            ["answers" => 'Fapt istoric: semnarea Pactului Molotov-Ribentrop din 23 august 1939', 
                "task" => 'Numește...', 
                "orderItem" => 1,
                "maxPoint" => 1],
            ["answers" => 'Argument: pe coperta cărții se vede denumirea "Pactului Molotov-Ribentrop", iar pe fotografie se văd semnatarii acestui document - Molotov și Ribentrop', 
                "task" => 'Argumentează...', 
                "orderItem" => 1,
                "maxPoint" => 2],
        ];

        $answer = $answers[$this->index];


        $answerContent = $answer['answers'];
        $task = $answer['task'];        
        $maxPoint = $answer['maxPoint'];
        $orderItem = $answer['orderItem'];

        $studyLevelId = StudyLevel::firstWhere('name', 'Ciclu gimnazial')->id;
        $subjectIstoriaId = Subject::firstWhere('name', 'Istoria')->id;
        $subjectStudyLevelId = SubjectStudyLevel::where('study_level_id', $studyLevelId) 
                                                ->where('subject_id', $subjectIstoriaId) ->first()->id;

        $themeId = Theme::where('name', 'România în Primul Război Mondial')->first()->id;

        $evaluationId = Evaluation::where('subject_study_level_id', $subjectStudyLevelId)
                                        ->where('year', 2022)
                                        ->first()->id;

        $evaluation_subjectId = EvaluationSubject::where('order_number', 1)
                                        ->where('evaluation_id', $evaluationId)
                                        ->first()->id;

        $evaluation_itemId = EvaluationItem::where('order_number', $orderItem)
                                        ->where('evaluation_subject_id', $evaluation_subjectId)        
                                        ->first()->id;

        $this->index++;

        return [
            'order_number' => $this->index,
            'content' => $answerContent,
            'task' => $task,
            'max_points' => $maxPoint,
            'evaluation_item_id'=> $evaluation_itemId
        ];
    }
}
