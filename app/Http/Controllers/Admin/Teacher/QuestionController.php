<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\User;
use App\Choice;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\ChoiceRequest;
use App\Http\Requests\QuestionRequest;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::orderBy('created_at', 'desc')->get();

        return view('back.teacher.qcm.questions', compact('questions'));
    }

    /**
     * Send you on the first form for create the question.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('back.teacher.qcm.create-first-step');
    }

    /**
     * Save the question and send you to the second step, register the diferent choices.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSecondStep(QuestionRequest $request)
    {
        $question = Question::create([
            'title'       => $request->title,
            'content'     => $request->content,
            'class_level' => $request->class_level,
            'status'      => $request->status
        ]);
        $number = $request->number_choice;

        return view('back.teacher.qcm.create-second-step', compact('question', 'number'));
    }

    /**
     * Save the choices and redirect the user to the index.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChoiceRequest $request)
    {
        for($i = 0; $i < $request->number; $i++) {
            $choice = Choice::create([
                'content' => $request->content[$i],
                'status' => $request->input($i),
                'question_id' => $request->question_id
            ]);
        }

        return redirect()->route('questions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);

        return view('back.teacher.qcm.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->title = $request->title;
        $question->content = $request->content;
        $question->save();

        return redirect()->route('questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id)->delete();

        return redirect()->route('questions.index');
    }
}
