<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Seed the topics inside every subject's "TOPICS" screen.
     *
     * Every subject in "Find More" now has its own topic breakdown, so
     * as soon as a user adds a subject to "My Subjects" the "{n} MCQs"
     * button opens a real topic list with "Study Now" practice and a
     * "TOPIC QUESTIONS" list on each topic.
     */
    public function run(): void
    {
        foreach ($this->breakdown() as $subjectName => $topicNames) {
            $this->seedTopics($subjectName, $topicNames);
        }
    }

    /**
     * subject name => ordered list of its topics.
     */
    private function breakdown(): array
    {
        return [
            // ---- Advanced Coding Languages ----
            'Bootstrap' => [
                'Bootstrap Basics & Setup',
                'Grid System & Layout',
                'Typography & Utilities',
                'Components & Navbars',
                'Forms & Validation',
                'Responsive Breakpoints',
            ],
            'C++ (OOP)' => [
                'C++ Basics',
                'C++ Operators',
                'C++ Control Structures',
                'C++ Functions',
                'C++ Object-Oriented Programming',
            ],
            'CSS (Cascading Style Sheets)' => [
                'CSS Basics & Syntax',
                'Selectors & Specificity',
                'Box Model & Spacing',
                'Flexbox & Grid',
                'Colors, Fonts & Text',
                'Transitions & Animations',
                'Responsive Design',
            ],
            'HTML' => [
                'HTML Basics & Structure',
                'Text & Formatting Tags',
                'Links, Images & Media',
                'Lists & Tables',
                'Forms & Inputs',
                'Semantic HTML5',
            ],
            'Java (OOP)' => [
                'Java Basics & Syntax',
                'Data Types & Operators',
                'Control Flow',
                'Methods & Arrays',
                'Classes & Objects',
                'Inheritance & Polymorphism',
                'Exception Handling',
            ],
            'JavaScript' => [
                'JavaScript Basics',
                'Variables & Data Types',
                'Operators & Control Flow',
                'Functions & Scope',
                'Arrays & Objects',
                'DOM Manipulation',
                'Events & Asynchronous JS',
            ],
            'Kotlin Basic & Advance' => [
                'Kotlin Basics & Syntax',
                'Variables, Types & Null Safety',
                'Control Flow & Loops',
                'Functions & Lambdas',
                'Classes & Objects',
                'Collections & Coroutines',
            ],
            'Node.js' => [
                'Node.js Fundamentals',
                'Modules & npm',
                'File System & Streams',
                'HTTP & Express Basics',
                'Asynchronous Node',
                'REST APIs & Middleware',
            ],
            'PHP (Hypertext Preprocessor)' => [
                'PHP Basics & Syntax',
                'Variables & Data Types',
                'Control Structures',
                'Functions & Arrays',
                'Forms & Superglobals',
                'Sessions, Cookies & Files',
                'PHP with MySQL',
            ],
            'Python' => [
                'Python Basics',
                'Data Types & Variables',
                'Control Flow',
                'Functions & Modules',
                'Lists, Tuples & Dictionaries',
                'File Handling & Exceptions',
                'Object-Oriented Python',
            ],
            'Swift' => [
                'Swift Basics & Syntax',
                'Constants, Variables & Optionals',
                'Control Flow',
                'Functions & Closures',
                'Structs, Classes & Enums',
                'Protocols & Extensions',
            ],
            'Wordpress' => [
                'WordPress Basics & Installation',
                'Dashboard & Settings',
                'Posts, Pages & Media',
                'Themes & Customisation',
                'Plugins & Widgets',
                'Users, SEO & Security',
            ],

            // ---- Advanced English Learning ----
            'Speaking English Skills' => [
                'Greetings & Introductions',
                'Everyday Conversation',
                'Formal & Informal Speech',
                'Common Phrases & Idioms',
                'Pronunciation & Stress',
                'Asking Questions',
                'Telephone & Email English',
                'Interview English',
            ],

            // ---- General Subjects ----
            'Computer Basics' => [
                'Introduction to Computers',
                'Hardware & Components',
                'Software & Operating Systems',
                'Input & Output Devices',
                'Memory & Storage',
                'Internet & Networking Basics',
                'Computer Security',
            ],
            'General Knowledge' => [
                'World Geography',
                'World History',
                'Pakistan Studies',
                'Science & Nature',
                'Sports & Games',
                'Current Affairs & Organisations',
            ],

            // ---- Khwaja Fareed University (KFUEIT) ----
            'Computer Networks' => [
                'Network Fundamentals',
                'OSI & TCP/IP Models',
                'Physical & Data Link Layer',
                'Network Layer & IP Addressing',
                'Transport Layer',
                'Application Layer Protocols',
                'Network Security',
            ],
            'Data Structure & Algorithm' => [
                'Arrays & Linked Lists',
                'Stacks & Queues',
                'Trees & Binary Search Trees',
                'Graphs & Traversal',
                'Sorting Algorithms',
                'Searching & Hashing',
                'Complexity Analysis',
            ],
            'Design & Analysis of Algorithms' => [
                'Asymptotic Notation',
                'Divide & Conquer',
                'Greedy Algorithms',
                'Dynamic Programming',
                'Graph Algorithms',
                'Backtracking & Branch and Bound',
                'NP-Completeness',
            ],
            'Object Oriented Programming (OOP)' => [
                'OOP Concepts',
                'Classes & Objects',
                'Encapsulation & Abstraction',
                'Inheritance',
                'Polymorphism',
                'Constructors & Destructors',
            ],
            'Web Programming' => [
                'Web Fundamentals',
                'HTML & CSS Essentials',
                'Client-Side Scripting',
                'Server-Side Basics',
                'Databases & Forms',
                'Sessions & Security',
            ],

            // ---- Productivity & Design Tools ----
            'MS Excel Learning' => [
                'Excel Interface & Basics',
                'Cells, Rows & Columns',
                'Formulas & Functions',
                'Formatting & Styles',
                'Charts & Graphs',
                'Sorting, Filtering & Pivot Tables',
            ],
            'MS Word Learning' => [
                'Word Interface & Basics',
                'Text Formatting',
                'Paragraphs & Styles',
                'Tables & Illustrations',
                'Page Layout & Printing',
                'Mail Merge & Review Tools',
            ],
            'Photoshop Learning' => [
                'Photoshop Interface & Tools',
                'Layers & Masks',
                'Selection Tools',
                'Retouching & Healing',
                'Colors & Adjustments',
                'Text, Shapes & Filters',
                'Saving & Exporting',
            ],

            // ---- Punjab Board of Intermediate ----
            '1st Year Biology' => [
                'Introduction to Biology',
                'Biological Molecules',
                'Enzymes',
                'The Cell',
                'Variety of Life & Kingdoms',
                'Bioenergetics',
                'Nutrition & Digestion',
            ],
            '1st Year Chemistry' => [
                'Basic Concepts of Chemistry',
                'Atomic Structure',
                'Chemical Bonding',
                'States of Matter',
                'Thermochemistry',
                'Chemical Equilibrium',
                'Solutions',
            ],
            '1st Year Computer Science' => [
                'Basics of Information Technology',
                'Computer Components',
                'Input / Output Devices',
                'Storage Devices',
                'Operating Systems',
                'Data Communication & Networks',
                'Introduction to Programming',
            ],
            '1st Year English' => [
                'Parts of Speech',
                'Tenses',
                'Active & Passive Voice',
                'Direct & Indirect Speech',
                'Synonyms & Antonyms',
                'Idioms & Prepositions',
                'Comprehension & Textbook',
            ],
            '1st Year Islamiat' => [
                'Quran & Its Teachings',
                'Seerat-un-Nabi (SAW)',
                'Hadith & Sunnah',
                'Pillars of Islam',
                'Islamic Society & Ethics',
            ],
            '1st Year Mathematics' => [
                'Number Systems',
                'Sets, Functions & Groups',
                'Matrices & Determinants',
                'Quadratic Equations',
                'Sequences & Series',
                'Trigonometry',
            ],
            '1st Year Physics' => [
                'Measurements',
                'Vectors & Equilibrium',
                'Motion & Force',
                'Work, Energy & Power',
                'Circular Motion',
                'Fluid Dynamics',
                'Waves & Oscillations',
                'Thermodynamics',
            ],
            '1st Year Sociology (Eng)' => [
                'Introduction to Sociology',
                'Society & Community',
                'Culture',
                'Socialization',
                'Social Groups & Institutions',
                'Social Change',
            ],
            '1st Year Sociology (Urdu)' => [
                'Introduction to Sociology',
                'Society & Community',
                'Culture',
                'Socialization',
                'Social Groups & Institutions',
                'Social Change',
            ],
            '2nd Year Biology' => [
                'Homeostasis',
                'Support & Movement',
                'Coordination & Control',
                'Reproduction',
                'Growth & Development',
                'Inheritance & Genetics',
                'Evolution & Ecosystem',
            ],
            '2nd Year Chemistry' => [
                'Periodic Classification',
                's & p Block Elements',
                'Transition Elements',
                'Organic Chemistry Basics',
                'Hydrocarbons',
                'Alcohols, Phenols & Ethers',
                'Environmental Chemistry',
            ],
            '2nd Year Computer Science' => [
                'Data Basics & Databases',
                'Database Design',
                'DBMS & MS Access',
                'Introduction to C Language',
                'Control Structures in C',
                'Functions & Arrays in C',
                'Pointers & File Handling',
            ],
            '2nd Year Education (Eng)' => [
                'Concept of Education',
                'Aims & Objectives of Education',
                'Curriculum & Teaching Methods',
                'Educational Psychology',
                'Education System in Pakistan',
            ],
            '2nd Year Education (Urdu)' => [
                'Concept of Education',
                'Aims & Objectives of Education',
                'Curriculum & Teaching Methods',
                'Educational Psychology',
                'Education System in Pakistan',
            ],
            '2nd Year English' => [
                'Tenses & Grammar',
                'Voice & Narration',
                'Vocabulary & Synonyms',
                'Idioms & Phrases',
                'Translation & Composition',
                'Book II & Plays',
                'Comprehension',
            ],
            '2nd Year Pak Study (Eng)' => [
                'Ideology of Pakistan',
                'Pakistan Movement',
                'Constitutional Development',
                'Land & People of Pakistan',
                'Economy & Resources',
                'Foreign Policy',
            ],
            '2nd Year Pak Study (Urdu)' => [
                'Ideology of Pakistan',
                'Pakistan Movement',
                'Constitutional Development',
                'Land & People of Pakistan',
                'Economy & Resources',
                'Foreign Policy',
            ],
            '2nd Year Physics' => [
                'Electrostatics',
                'Current Electricity',
                'Electromagnetism',
                'Electromagnetic Induction',
                'Alternating Current',
                'Modern Physics',
                'Atomic & Nuclear Physics',
            ],
            '2nd Year Sociology (Eng)' => [
                'Social Institutions',
                'Family & Marriage',
                'Religion & Society',
                'Social Problems',
                'Population & Urbanisation',
                'Research Methods',
            ],
            '2nd Year Sociology (Urdu)' => [
                'Social Institutions',
                'Family & Marriage',
                'Religion & Society',
                'Social Problems',
                'Population & Urbanisation',
                'Research Methods',
            ],
        ];
    }

    private function seedTopics(string $subjectName, array $topicNames): void
    {
        $subject = Subject::where('name', $subjectName)->first();

        if (! $subject) {
            return;
        }

        foreach ($topicNames as $index => $name) {
            Topic::updateOrCreate(
                ['subject_id' => $subject->id, 'name' => $name],
                [
                    'subject_id' => $subject->id,
                    'name' => $name,
                    'icon' => '📖',
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
