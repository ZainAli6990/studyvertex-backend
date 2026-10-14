<?php

namespace Database\Seeders;

use App\Models\Mcq;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class McqSeeder extends Seeder
{
    /**
     * Seed real, verified multiple-choice questions for the C++ (OOP)
     * topics. This is a genuine starter question bank (not filler) --
     * growing it to match the much larger MCQ counts shown in the
     * reference app is a separate, ongoing content task.
     */
    public function run(): void
    {
        $subject = Subject::where('name', 'C++ (OOP)')->first();

        if (! $subject) {
            return;
        }

        $bank = [
            'C++ Basics' => [
                ['q' => 'What does "C++" stand for?', 'options' => ['A web browser', 'A programming language', 'An operating system', 'A database'], 'correct' => 1],
                ['q' => 'What symbol is used to end a statement in C++?', 'options' => ['Comma (,)', 'Colon (:)', 'Period (.)', 'Semicolon (;)'], 'correct' => 3],
                ['q' => 'How do you write a single-line comment in C++?', 'options' => ['<!-- comment -->', '# comment', '// comment', '** comment **'], 'correct' => 2],
                ['q' => 'Which header file is required for basic input/output in C++?', 'options' => ['<stdio.h>', '<iostream>', '<conio.h>', '<math.h>'], 'correct' => 1],
                ['q' => 'What is the correct file extension for a C++ source file?', 'options' => ['.java', '.py', '.cpp', '.cs'], 'correct' => 2],
                ['q' => 'Which keyword is used to define a constant in C++?', 'options' => ['constant', 'final', 'const', 'static'], 'correct' => 2],
                ['q' => 'What is the correct way to print "Hello World" in C++?', 'options' => ['print("Hello World");', 'cout << "Hello World";', 'echo "Hello World";', 'System.out.println("Hello World");'], 'correct' => 1],
                ['q' => 'Which of the following is a valid C++ variable name?', 'options' => ['2value', 'value-2', '_value', 'value 2'], 'correct' => 2],
                ['q' => 'What is the typical size of an "int" on most modern systems in C++?', 'options' => ['1 byte', '2 bytes', '4 bytes', '8 bytes'], 'correct' => 2],
                ['q' => 'Who is considered the creator of C++?', 'options' => ['Dennis Ritchie', 'Bjarne Stroustrup', 'James Gosling', 'Guido van Rossum'], 'correct' => 1],
            ],
            'C++ Operators' => [
                ['q' => 'Which operator is used for addition in C++?', 'options' => ['+', '-', '*', '/'], 'correct' => 0],
                ['q' => 'What does the "%" operator do in C++?', 'options' => ['Divides two numbers', 'Multiplies two numbers', 'Returns the remainder of division', 'Rounds a number'], 'correct' => 2],
                ['q' => 'Which operator checks if two values are equal in C++?', 'options' => ['=', '==', '!=', '==='], 'correct' => 1],
                ['q' => 'What is the result of "5 / 2" using integer division in C++?', 'options' => ['2.5', '2', '3', '0'], 'correct' => 1],
                ['q' => 'Which operator increases a variable\'s value by 1?', 'options' => ['+=', '++', '--', '**'], 'correct' => 1],
                ['q' => 'What does the "&&" operator represent?', 'options' => ['Logical OR', 'Bitwise AND', 'Logical AND', 'Assignment'], 'correct' => 2],
                ['q' => 'Which operator is used to assign a value to a variable?', 'options' => ['==', ':=', '=', '=>'], 'correct' => 2],
                ['q' => 'What does the "!=" operator check for?', 'options' => ['Equal to', 'Not equal to', 'Greater than', 'Less than'], 'correct' => 1],
                ['q' => 'Which has the highest precedence in an expression?', 'options' => ['+', '*', '()', '='], 'correct' => 2],
                ['q' => 'What does the ternary operator "?:" do?', 'options' => ['Loops a fixed number of times', 'Declares a pointer', 'Chooses between two values based on a condition', 'Casts a variable\'s type'], 'correct' => 2],
            ],
            'C++ Control Structures' => [
                ['q' => 'Which keyword starts a basic conditional statement in C++?', 'options' => ['when', 'if', 'check', 'case'], 'correct' => 1],
                ['q' => 'Which loop is guaranteed to execute its body at least once?', 'options' => ['for', 'while', 'do-while', 'foreach'], 'correct' => 2],
                ['q' => 'Which statement immediately exits a loop?', 'options' => ['continue', 'break', 'return', 'exit'], 'correct' => 1],
                ['q' => 'Which statement skips the rest of the current iteration and moves to the next?', 'options' => ['break', 'continue', 'skip', 'pass'], 'correct' => 1],
                ['q' => 'Which control structure is best for choosing among many fixed values?', 'options' => ['if-else chain', 'while loop', 'switch', 'goto'], 'correct' => 2],
                ['q' => 'How many times does "for(int i = 0; i < 5; i++)" run its body?', 'options' => ['4', '5', '6', 'Infinite'], 'correct' => 1],
                ['q' => 'What does the "default" case do in a switch statement?', 'options' => ['Runs first, always', 'Runs when no other case matches', 'Ends the switch immediately', 'Causes an error'], 'correct' => 1],
                ['q' => 'Which keyword lets you chain another condition after "if"?', 'options' => ['elseif', 'else if', 'elif', 'orif'], 'correct' => 1],
                ['q' => 'What happens if you forget a "break" inside a switch case?', 'options' => ['A compile error occurs', 'The switch exits immediately', 'Execution falls through to the next case', 'Nothing happens'], 'correct' => 2],
                ['q' => 'Which loop suits a task where the number of iterations is known beforehand?', 'options' => ['while loop', 'do-while loop', 'for loop', 'if statement'], 'correct' => 2],
            ],
            'C++ Functions' => [
                ['q' => 'Which keyword is used for a function that returns nothing?', 'options' => ['null', 'void', 'none', 'empty'], 'correct' => 1],
                ['q' => 'What is it called when a function calls itself?', 'options' => ['Overloading', 'Recursion', 'Overriding', 'Inheritance'], 'correct' => 1],
                ['q' => 'What is function overloading in C++?', 'options' => ['Running the same function twice', 'Multiple functions with the same name but different parameters', 'A function calling itself', 'A function with no return type'], 'correct' => 1],
                ['q' => 'Which of these is a valid function prototype?', 'options' => ['int add(int, int);', 'function add(int, int)', 'def add(int, int):', 'int add[int, int];'], 'correct' => 0],
                ['q' => 'What is a "default argument" in a C++ function?', 'options' => ['An argument that must always be passed', 'A value used automatically if no argument is passed', 'The first parameter only', 'An argument of type int'], 'correct' => 1],
                ['q' => 'What does "pass by reference" mean?', 'options' => ['The function gets a copy of the variable', 'The function receives the actual variable, not a copy', 'The function can\'t modify the argument', 'The argument is passed as text'], 'correct' => 1],
                ['q' => 'Which symbol marks a parameter as passed by reference?', 'options' => ['*', '&', '#', '@'], 'correct' => 1],
                ['q' => 'What is the scope of a variable declared inside a function?', 'options' => ['Global', 'Local to that function', 'Local to the whole file', 'Local to the class only'], 'correct' => 1],
                ['q' => 'What must a non-void function always include?', 'options' => ['A loop', 'A return statement', 'A default argument', 'A pointer'], 'correct' => 1],
                ['q' => 'What is an "inline" function mainly used for?', 'options' => ['Hiding the function from other files', 'Suggesting the compiler expand the call for speed', 'Making the function recursive', 'Overloading the function'], 'correct' => 1],
            ],
            'C++ Object-Oriented Programming' => [
                ['q' => 'Which of these is NOT one of the four main pillars of OOP?', 'options' => ['Encapsulation', 'Inheritance', 'Compilation', 'Polymorphism'], 'correct' => 2],
                ['q' => 'What is a class in C++?', 'options' => ['A running instance of data', 'A blueprint for creating objects', 'A loop construct', 'A built-in data type'], 'correct' => 1],
                ['q' => 'What is an object in C++?', 'options' => ['A function prototype', 'An instance of a class', 'A type of loop', 'A header file'], 'correct' => 1],
                ['q' => 'Which keyword defines a class in C++?', 'options' => ['struct', 'object', 'class', 'define'], 'correct' => 2],
                ['q' => 'What does inheritance allow a class to do?', 'options' => ['Delete another class', 'Acquire properties of another class', 'Run faster', 'Skip the constructor'], 'correct' => 1],
                ['q' => 'What is polymorphism in OOP?', 'options' => ['Having only one function per class', 'The ability of a function/object to take many forms', 'Hiding all class members', 'Compiling code twice'], 'correct' => 1],
                ['q' => 'Which access specifier restricts members to only within the class?', 'options' => ['public', 'protected', 'private', 'external'], 'correct' => 2],
                ['q' => 'What is a constructor?', 'options' => ['A function that deletes an object', 'A special function called when an object is created', 'A loop inside a class', 'A private variable'], 'correct' => 1],
                ['q' => 'What does encapsulation mean in OOP?', 'options' => ['Splitting a program into many files', 'Bundling data and the methods that operate on it within a class', 'Making all variables global', 'Removing unused functions'], 'correct' => 1],
                ['q' => 'What is a "virtual" function mainly used for?', 'options' => ['Making a function faster', 'Enabling runtime polymorphism (dynamic binding)', 'Hiding a function from subclasses', 'Declaring a constant'], 'correct' => 1],
            ],
        ];

        foreach ($bank as $topicName => $questions) {
            $topic = Topic::where('subject_id', $subject->id)->where('name', $topicName)->first();

            if (! $topic) {
                continue;
            }

            foreach ($questions as $index => $item) {
                Mcq::updateOrCreate(
                    ['topic_id' => $topic->id, 'question' => $item['q']],
                    [
                        'topic_id' => $topic->id,
                        'question' => $item['q'],
                        'options' => $item['options'],
                        'correct_index' => $item['correct'],
                        'sort_order' => $index + 1,
                    ]
                );
            }
        }
    }
}
