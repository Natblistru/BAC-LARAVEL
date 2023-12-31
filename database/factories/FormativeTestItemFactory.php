<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FormativeTestItem;
use App\Models\FormativeTest;
use App\Models\TeacherTopic;
use App\Models\Teacher;
use App\Models\Topic;
use App\Models\Test;
use App\Models\TestItem;


class FormativeTestItemFactory extends Factory
{
    private $index = 0;
    public function definition(): array
    {
        $taskTypes = [
            ["task" => "Alege afirmația corectă", "test_item_id" => 1, "order" => 1],
            ["task" => "Stabilește cauzele evenimentelor", "test_item_id" => 2, "order" => 1],
            ["task" => "Stabilește consecințele evenimentelor", "test_item_id" => 3, "order" => 1],
            ["task" => "Verifică corectitudinea afirmațiilor", "test_item_id" => 4, "order" => 1],
            ["task" => "Formează perechi logice", "test_item_id" => 5, "order" => 1],
            ["task" => "Grupează elementele", "test_item_id" => 6, "order" => 1],
            ["task" => "Caracteristicile evenimentelor", "test_item_id" => 7, "order" => 1],
            ["task" => "Completează propoziția", "test_item_id" => 8, "order" => 1],
            ["task" => "Elaborează un fragment de text", "test_item_id" => 9, "order" => 1],
            ["task" => "Succesiunea cronologică a evenimentelor", "test_item_id" => 10, "order" => 1],
            ["task" => "Alege afirmația corectă", "test_item_id" => 11, "order" => 2], 
            ["task" => "Alege afirmația corectă", "test_item_id" => 12, "order" => 3],        
            ["task" => "Alege afirmația corectă", "test_item_id" => 13, "order" => 4],        
            ["task" => "Alege afirmația corectă", "test_item_id" => 14, "order" => 5], 
            ["task" => "Stabilește cauzele evenimentelor", "test_item_id" => 15, "order" => 2],  
            ["task" => "Stabilește consecințele evenimentelor", "test_item_id" => 16, "order" => 2],   
            ["task" => "Verifică corectitudinea afirmațiilor", "test_item_id" => 17, "order" => 2],
            ["task" => "Formează perechi logice", "test_item_id" => 18, "order" => 2], 
            ["task" => "Grupează elementele", "test_item_id" => 19, "order" => 2], 
            ["task" => "Caracteristicile evenimentelor", "test_item_id" => 20, "order" => 2],
            ["task" => "Completează propoziția", "test_item_id" => 21, "order" => 2],        
            ["task" => "Elaborează un fragment de text", "test_item_id" => 22, "order" => 2], 
            ["task" => "Succesiunea cronologică a evenimentelor", "test_item_id" => 23, "order" => 2], 
            ["task" => "Completează propoziția", "test_item_id" => 24, "order" => 3],          
            
        ];
        
        $taskType = $taskTypes[$this->index];
        // $path = $taskType['path'];
        $task = $taskType['task'];
        $testItemId = $taskType['test_item_id'];
        $order = $taskType['order'];


        $teacherId = Teacher::firstWhere('name', 'userT1 teacher')->id;
        $topicId = Topic::firstWhere('name', 'Opțiunile politice în perioada neutralității')->id;

        $teacherTopictId = TeacherTopic::where('teacher_id', $teacherId)
                                            ->where('topic_id', $topicId)
                                            ->first()->id;
        $formativeTestId = FormativeTest::where('teacher_topic_id', $teacherTopictId)
                                            ->where('title', $task)
                                            ->first()->id;

        // $testItemId = TestItem::where('type', $type)
        //                         ->where('task', $task)
        //                         ->first()->id;

        $this->index++;
    
        return [
            'order_number' =>  $order,
            'formative_test_id' => $formativeTestId,
            'test_item_id' => $testItemId,
        ];
    }
}
