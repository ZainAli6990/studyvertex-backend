<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Verified starter question bank for the coding, tools, English and
 * university subjects. Every subject here has practiceable questions
 * so "Study Now" and "TOPIC QUESTIONS" work the moment the subject is
 * added to "My Subjects".
 */
class McqTechSeeder extends Seeder
{
    use SeedsMcqs;

    public function run(): void
    {
        $this->seedBank($this->bank());
    }

    private function bank(): array
    {
        return [
            'Bootstrap' => [
                'Bootstrap Basics & Setup' => [
                    ['q' => 'What is Bootstrap mainly used for?', 'options' => ['Managing databases', 'Building responsive front-end interfaces', 'Compiling C++ code', 'Configuring web servers'], 'correct' => 1],
                    ['q' => 'Which language is Bootstrap primarily built with?', 'options' => ['Python', 'CSS and JavaScript', 'PHP', 'Ruby'], 'correct' => 1],
                    ['q' => 'Which class creates a fixed-width centered container?', 'options' => ['.container', '.wrapper', '.box', '.frame'], 'correct' => 0],
                ],
                'Grid System & Layout' => [
                    ['q' => 'How many columns does the default Bootstrap grid have?', 'options' => ['6', '10', '12', '16'], 'correct' => 2],
                    ['q' => 'Which class marks a horizontal group of columns?', 'options' => ['.line', '.row', '.grid', '.flex'], 'correct' => 1],
                    ['q' => 'What does the class "col-md-6" mean?', 'options' => ['6 pixels wide on medium screens', 'Half the row width on medium screens and up', 'Six rows tall', 'Six nested columns'], 'correct' => 1],
                ],
                'Components & Navbars' => [
                    ['q' => 'Which class styles a primary action button?', 'options' => ['.btn-main', '.button-primary', '.btn .btn-primary', '.primary-btn'], 'correct' => 2],
                    ['q' => 'Which component is used for a collapsible site menu?', 'options' => ['Navbar', 'Jumbotron', 'Badge', 'Spinner'], 'correct' => 0],
                ],
            ],

            'CSS (Cascading Style Sheets)' => [
                'CSS Basics & Syntax' => [
                    ['q' => 'What does CSS stand for?', 'options' => ['Computer Style Sheets', 'Cascading Style Sheets', 'Creative Style System', 'Coded Style Syntax'], 'correct' => 1],
                    ['q' => 'Which HTML tag is used to write internal CSS?', 'options' => ['<css>', '<script>', '<style>', '<link>'], 'correct' => 2],
                    ['q' => 'Which property changes the text colour of an element?', 'options' => ['font-color', 'color', 'text-style', 'foreground'], 'correct' => 1],
                ],
                'Selectors & Specificity' => [
                    ['q' => 'Which symbol selects an element by its id?', 'options' => ['.', '#', '*', '@'], 'correct' => 1],
                    ['q' => 'Which selector has the highest specificity?', 'options' => ['Element selector', 'Class selector', 'ID selector', 'Universal selector'], 'correct' => 2],
                ],
                'Box Model & Spacing' => [
                    ['q' => 'Which part of the box model sits outside the border?', 'options' => ['Padding', 'Margin', 'Content', 'Outline width'], 'correct' => 1],
                    ['q' => 'Which property adds space inside an element, between content and border?', 'options' => ['margin', 'padding', 'gap', 'spacing'], 'correct' => 1],
                ],
                'Flexbox & Grid' => [
                    ['q' => 'Which value of "display" turns an element into a flex container?', 'options' => ['block', 'inline', 'flex', 'table'], 'correct' => 2],
                    ['q' => 'Which property aligns flex items along the main axis?', 'options' => ['align-items', 'justify-content', 'flex-wrap', 'order'], 'correct' => 1],
                ],
            ],

            'HTML' => [
                'HTML Basics & Structure' => [
                    ['q' => 'What does HTML stand for?', 'options' => ['Hyper Text Markup Language', 'High Level Text Machine Language', 'Hyperlink Text Mark Language', 'Home Tool Markup Language'], 'correct' => 0],
                    ['q' => 'Which tag contains the visible content of a web page?', 'options' => ['<head>', '<body>', '<meta>', '<title>'], 'correct' => 1],
                    ['q' => 'Which declaration tells the browser the document is HTML5?', 'options' => ['<!DOCTYPE html>', '<html5>', '<doc html>', '<version 5>'], 'correct' => 0],
                ],
                'Text & Formatting Tags' => [
                    ['q' => 'Which tag creates the largest heading?', 'options' => ['<h6>', '<head>', '<h1>', '<big>'], 'correct' => 2],
                    ['q' => 'Which tag is used for a line break?', 'options' => ['<lb>', '<br>', '<break>', '<nl>'], 'correct' => 1],
                ],
                'Links, Images & Media' => [
                    ['q' => 'Which attribute of <a> holds the destination URL?', 'options' => ['src', 'link', 'href', 'target'], 'correct' => 2],
                    ['q' => 'Which attribute gives alternative text for an image?', 'options' => ['title', 'alt', 'caption', 'desc'], 'correct' => 1],
                ],
                'Forms & Inputs' => [
                    ['q' => 'Which attribute of <form> decides where data is sent?', 'options' => ['action', 'method', 'target', 'send'], 'correct' => 0],
                    ['q' => 'Which input type hides the characters typed by the user?', 'options' => ['text', 'hidden', 'password', 'secret'], 'correct' => 2],
                ],
            ],

            'Java (OOP)' => [
                'Java Basics & Syntax' => [
                    ['q' => 'Which method is the entry point of a Java program?', 'options' => ['start()', 'main()', 'run()', 'init()'], 'correct' => 1],
                    ['q' => 'What is the file extension of a Java source file?', 'options' => ['.jv', '.jar', '.java', '.class'], 'correct' => 2],
                    ['q' => 'What does JVM stand for?', 'options' => ['Java Variable Manager', 'Java Virtual Machine', 'Just Verified Method', 'Java Version Model'], 'correct' => 1],
                ],
                'Classes & Objects' => [
                    ['q' => 'Which keyword creates a new object in Java?', 'options' => ['create', 'new', 'object', 'alloc'], 'correct' => 1],
                    ['q' => 'A constructor in Java must have the same name as its...', 'options' => ['Package', 'Class', 'File only', 'Method'], 'correct' => 1],
                ],
                'Inheritance & Polymorphism' => [
                    ['q' => 'Which keyword is used for inheritance in Java?', 'options' => ['inherits', 'extends', 'implements', 'derives'], 'correct' => 1],
                    ['q' => 'Method overriding happens between...', 'options' => ['Two methods in the same class', 'A parent class method and a child class method', 'Two unrelated classes', 'A method and a constructor'], 'correct' => 1],
                ],
                'Exception Handling' => [
                    ['q' => 'Which block always runs whether or not an exception occurs?', 'options' => ['try', 'catch', 'finally', 'throw'], 'correct' => 2],
                ],
            ],

            'JavaScript' => [
                'JavaScript Basics' => [
                    ['q' => 'Which HTML tag is used to include JavaScript?', 'options' => ['<js>', '<script>', '<javascript>', '<code>'], 'correct' => 1],
                    ['q' => 'Which method prints a message to the browser console?', 'options' => ['print()', 'console.log()', 'echo()', 'write()'], 'correct' => 1],
                ],
                'Variables & Data Types' => [
                    ['q' => 'Which keyword declares a block-scoped variable that can be reassigned?', 'options' => ['var', 'let', 'const', 'static'], 'correct' => 1],
                    ['q' => 'What does "typeof []" return in JavaScript?', 'options' => ['"array"', '"object"', '"list"', '"undefined"'], 'correct' => 1],
                    ['q' => 'Which value represents "no value assigned yet"?', 'options' => ['null', 'undefined', '0', 'NaN'], 'correct' => 1],
                ],
                'Operators & Control Flow' => [
                    ['q' => 'Which operator compares both value and type?', 'options' => ['==', '===', '=', '!='], 'correct' => 1],
                    ['q' => 'What is the result of "2" + 2 in JavaScript?', 'options' => ['4', '"22"', 'NaN', 'Error'], 'correct' => 1],
                ],
                'Arrays & Objects' => [
                    ['q' => 'Which method adds an element to the end of an array?', 'options' => ['push()', 'pop()', 'shift()', 'concat()'], 'correct' => 0],
                    ['q' => 'Which method creates a new array with every element transformed?', 'options' => ['forEach()', 'map()', 'filter()', 'reduce()'], 'correct' => 1],
                ],
                'DOM Manipulation' => [
                    ['q' => 'Which method selects the first element matching a CSS selector?', 'options' => ['getElement()', 'querySelector()', 'findElement()', 'selectNode()'], 'correct' => 1],
                ],
            ],

            'Kotlin Basic & Advance' => [
                'Kotlin Basics & Syntax' => [
                    ['q' => 'Which company created Kotlin?', 'options' => ['Google', 'JetBrains', 'Oracle', 'Microsoft'], 'correct' => 1],
                    ['q' => 'What is the entry point of a Kotlin program?', 'options' => ['start()', 'main()', 'begin()', 'init()'], 'correct' => 1],
                ],
                'Variables, Types & Null Safety' => [
                    ['q' => 'Which keyword declares a read-only variable in Kotlin?', 'options' => ['var', 'val', 'let', 'const only'], 'correct' => 1],
                    ['q' => 'Which symbol marks a type as nullable in Kotlin?', 'options' => ['!', '?', '*', '&'], 'correct' => 1],
                    ['q' => 'What does the "?:" operator do in Kotlin?', 'options' => ['Casts a type', 'Returns a default value when the left side is null', 'Declares a lambda', 'Compares two objects'], 'correct' => 1],
                ],
                'Functions & Lambdas' => [
                    ['q' => 'Which keyword declares a function in Kotlin?', 'options' => ['func', 'def', 'fun', 'function'], 'correct' => 2],
                ],
                'Classes & Objects' => [
                    ['q' => 'Which Kotlin class type automatically provides equals(), hashCode() and toString()?', 'options' => ['sealed class', 'data class', 'object', 'abstract class'], 'correct' => 1],
                ],
            ],

            'Node.js' => [
                'Node.js Fundamentals' => [
                    ['q' => 'Node.js runs JavaScript using which engine?', 'options' => ['SpiderMonkey', 'V8', 'JavaScriptCore', 'Chakra'], 'correct' => 1],
                    ['q' => 'Node.js is best described as...', 'options' => ['A browser', 'A JavaScript runtime for server-side code', 'A database', 'A CSS framework'], 'correct' => 1],
                ],
                'Modules & npm' => [
                    ['q' => 'Which file records a Node project\'s dependencies?', 'options' => ['node.json', 'package.json', 'config.js', 'modules.txt'], 'correct' => 1],
                    ['q' => 'Which function loads a module in CommonJS?', 'options' => ['import()', 'require()', 'include()', 'load()'], 'correct' => 1],
                    ['q' => 'What does npm stand for?', 'options' => ['Node Package Manager', 'New Project Module', 'Node Program Memory', 'Nested Package Method'], 'correct' => 0],
                ],
                'HTTP & Express Basics' => [
                    ['q' => 'Which built-in module creates a web server in Node.js?', 'options' => ['fs', 'http', 'path', 'os'], 'correct' => 1],
                    ['q' => 'In Express, which method handles a GET request?', 'options' => ['app.fetch()', 'app.get()', 'app.read()', 'app.route()'], 'correct' => 1],
                ],
            ],

            'PHP (Hypertext Preprocessor)' => [
                'PHP Basics & Syntax' => [
                    ['q' => 'Which tag opens a block of PHP code?', 'options' => ['<php>', '<?php', '<%', '<script php>'], 'correct' => 1],
                    ['q' => 'PHP code is executed on the...', 'options' => ['Client browser', 'Server', 'Database only', 'Router'], 'correct' => 1],
                ],
                'Variables & Data Types' => [
                    ['q' => 'Which symbol starts a variable name in PHP?', 'options' => ['#', '@', '$', '&'], 'correct' => 2],
                    ['q' => 'Which function prints output in PHP?', 'options' => ['console.log()', 'echo', 'printf only', 'display()'], 'correct' => 1],
                ],
                'Functions & Arrays' => [
                    ['q' => 'Which function returns the number of elements in an array?', 'options' => ['size()', 'count()', 'length()', 'total()'], 'correct' => 1],
                    ['q' => 'Which array type uses named keys in PHP?', 'options' => ['Indexed array', 'Associative array', 'Static array', 'Linked array'], 'correct' => 1],
                ],
                'Forms & Superglobals' => [
                    ['q' => 'Which superglobal collects data sent with method="post"?', 'options' => ['$_GET', '$_POST', '$_FORM', '$_DATA'], 'correct' => 1],
                    ['q' => 'Which superglobal holds uploaded file information?', 'options' => ['$_FILES', '$_UPLOAD', '$_MEDIA', '$_DOC'], 'correct' => 0],
                ],
            ],

            'Python' => [
                'Python Basics' => [
                    ['q' => 'Which symbol begins a comment in Python?', 'options' => ['//', '#', '--', '/*'], 'correct' => 1],
                    ['q' => 'Which function displays output in Python 3?', 'options' => ['echo()', 'print()', 'write()', 'output()'], 'correct' => 1],
                    ['q' => 'How are code blocks defined in Python?', 'options' => ['Curly braces', 'Indentation', 'begin/end keywords', 'Semicolons'], 'correct' => 1],
                ],
                'Data Types & Variables' => [
                    ['q' => 'Which of these is an immutable Python type?', 'options' => ['list', 'dict', 'tuple', 'set'], 'correct' => 2],
                    ['q' => 'What does type(5/2) return in Python 3?', 'options' => ['int', 'float', 'decimal', 'str'], 'correct' => 1],
                ],
                'Control Flow' => [
                    ['q' => 'Which keyword starts a loop over a sequence?', 'options' => ['foreach', 'loop', 'for', 'repeat'], 'correct' => 2],
                    ['q' => 'Which statement skips to the next loop iteration?', 'options' => ['break', 'continue', 'pass', 'next'], 'correct' => 1],
                ],
                'Functions & Modules' => [
                    ['q' => 'Which keyword defines a function in Python?', 'options' => ['func', 'def', 'function', 'fun'], 'correct' => 1],
                    ['q' => 'Which statement brings a module into your program?', 'options' => ['include', 'require', 'import', 'use'], 'correct' => 2],
                ],
                'Lists, Tuples & Dictionaries' => [
                    ['q' => 'Which method adds an item to the end of a list?', 'options' => ['add()', 'append()', 'insert()', 'push()'], 'correct' => 1],
                ],
            ],

            'Swift' => [
                'Swift Basics & Syntax' => [
                    ['q' => 'Which company developed Swift?', 'options' => ['Google', 'Apple', 'Microsoft', 'IBM'], 'correct' => 1],
                    ['q' => 'Which function prints to the console in Swift?', 'options' => ['echo()', 'print()', 'log()', 'NSLog only'], 'correct' => 1],
                ],
                'Constants, Variables & Optionals' => [
                    ['q' => 'Which keyword declares a constant in Swift?', 'options' => ['var', 'let', 'const', 'final'], 'correct' => 1],
                    ['q' => 'What does an optional in Swift represent?', 'options' => ['A value that is always present', 'A value that may be present or nil', 'A constant only', 'A protocol'], 'correct' => 1],
                    ['q' => 'Which symbol force-unwraps an optional?', 'options' => ['?', '!', '&', '*'], 'correct' => 1],
                ],
                'Functions & Closures' => [
                    ['q' => 'Which keyword declares a function in Swift?', 'options' => ['fun', 'def', 'func', 'function'], 'correct' => 2],
                ],
                'Structs, Classes & Enums' => [
                    ['q' => 'In Swift, a struct is a...', 'options' => ['Reference type', 'Value type', 'Protocol', 'Closure'], 'correct' => 1],
                ],
            ],

            'Wordpress' => [
                'WordPress Basics & Installation' => [
                    ['q' => 'WordPress is written mainly in which language?', 'options' => ['Python', 'PHP', 'Ruby', 'Java'], 'correct' => 1],
                    ['q' => 'Which database does a standard WordPress install use?', 'options' => ['MongoDB', 'MySQL', 'SQLite', 'Oracle'], 'correct' => 1],
                    ['q' => 'Which file stores the database connection settings of a WordPress site?', 'options' => ['index.php', 'wp-config.php', 'functions.php', 'style.css'], 'correct' => 1],
                ],
                'Posts, Pages & Media' => [
                    ['q' => 'What is the main difference between a post and a page?', 'options' => ['Pages are dated and listed chronologically', 'Posts are dated blog entries, pages are static content', 'Posts cannot contain images', 'There is no difference'], 'correct' => 1],
                    ['q' => 'What is a "permalink" in WordPress?', 'options' => ['A temporary preview link', 'The permanent URL of a post or page', 'A plugin licence', 'A backup file'], 'correct' => 1],
                ],
                'Themes & Customisation' => [
                    ['q' => 'What controls the overall look of a WordPress site?', 'options' => ['Plugin', 'Theme', 'Widget', 'Permalink'], 'correct' => 1],
                    ['q' => 'What is a child theme used for?', 'options' => ['Speeding up the site', 'Customising a theme without losing changes on update', 'Adding users', 'Creating backups'], 'correct' => 1],
                ],
                'Plugins & Widgets' => [
                    ['q' => 'What does a plugin add to WordPress?', 'options' => ['Visual design only', 'Extra functionality', 'Hosting space', 'A domain name'], 'correct' => 1],
                ],
            ],

            'Speaking English Skills' => [
                'Greetings & Introductions' => [
                    ['q' => 'Which greeting is most appropriate in a formal meeting?', 'options' => ['"What\'s up?"', '"Good morning, it\'s a pleasure to meet you."', '"Yo!"', '"Hey there!"'], 'correct' => 1],
                    ['q' => 'What is the natural reply to "How do you do?"', 'options' => ['"I am fine, thank you."', '"How do you do?"', '"Nothing much."', '"I do well."'], 'correct' => 1],
                ],
                'Formal & Informal Speech' => [
                    ['q' => 'How would you say "I am writing to request" informally?', 'options' => ['"I need to ask"', '"I\'m requesting"', '"I want to know"', '"Can I ask for"'], 'correct' => 3],
                    ['q' => 'How would you say "I am writing to request an extension" informally?', 'options' => ['"Need more time"', '"Please extend the deadline"', '"I need a bit more time"', '"Can I get an extension?"'], 'correct' => 3],
                    ['q' => 'Which sentence is the most formal?', 'options' => ['"Can you send it over?"', '"Could you kindly forward the document?"', '"Send it to me."', '"Shoot me the file."'], 'correct' => 1],
                    ['q' => 'Which phrase is informal for "I apologise for the delay"?', 'options' => ['"Please accept my apologies"', '"Sorry for the hold-up"', '"I regret the postponement"', '"My sincere apologies"'], 'correct' => 1],
                ],
                'Everyday Conversation' => [
                    ['q' => 'Which reply best accepts an invitation?', 'options' => ['"I\'d love to, thanks!"', '"Maybe not."', '"Why are you asking?"', '"I\'m busy."'], 'correct' => 0],
                    ['q' => 'What does "How are you getting on?" mean?', 'options' => ['How are you travelling?', 'How are you managing or progressing?', 'Where are you going?', 'When did you arrive?'], 'correct' => 1],
                ],
                'Common Phrases & Idioms' => [
                    ['q' => 'What does the idiom "break the ice" mean?', 'options' => ['To end a friendship', 'To start a conversation and ease tension', 'To make a mistake', 'To cancel a plan'], 'correct' => 1],
                    ['q' => 'What does "piece of cake" mean?', 'options' => ['Something very easy', 'Something expensive', 'A dessert order', 'A small portion'], 'correct' => 0],
                ],
                'Asking Questions' => [
                    ['q' => 'Which is the most polite way to ask for help?', 'options' => ['"Help me."', '"Could you help me, please?"', '"You must help me."', '"Help, now."'], 'correct' => 1],
                ],
                'Interview English' => [
                    ['q' => 'Which is the strongest answer to "Tell me about yourself"?', 'options' => ['A list of your hobbies only', 'A short summary of your background, skills and goals', 'Your full life story', 'A question back to the interviewer'], 'correct' => 1],
                ],
            ],

            'Computer Basics' => [
                'Introduction to Computers' => [
                    ['q' => 'What does CPU stand for?', 'options' => ['Central Processing Unit', 'Computer Personal Unit', 'Central Program Utility', 'Control Processing Unit'], 'correct' => 0],
                    ['q' => 'Which part of the computer is called its "brain"?', 'options' => ['Monitor', 'CPU', 'Hard disk', 'Keyboard'], 'correct' => 1],
                ],
                'Hardware & Components' => [
                    ['q' => 'Which of these is hardware?', 'options' => ['MS Word', 'Motherboard', 'Windows 11', 'Chrome'], 'correct' => 1],
                    ['q' => 'What does GPU stand for?', 'options' => ['General Purpose Unit', 'Graphics Processing Unit', 'Global Program Utility', 'Grouped Power Unit'], 'correct' => 1],
                ],
                'Software & Operating Systems' => [
                    ['q' => 'Which of these is an operating system?', 'options' => ['Photoshop', 'Linux', 'Excel', 'Firefox'], 'correct' => 1],
                    ['q' => 'System software is software that...', 'options' => ['Runs and manages the computer itself', 'Is used only for games', 'Only edits documents', 'Only connects printers'], 'correct' => 0],
                ],
                'Memory & Storage' => [
                    ['q' => 'Which memory loses its contents when power is switched off?', 'options' => ['ROM', 'RAM', 'Hard disk', 'SSD'], 'correct' => 1],
                    ['q' => 'How many bytes are in one kilobyte (KB)?', 'options' => ['8', '100', '1024', '1000000'], 'correct' => 2],
                ],
                'Input & Output Devices' => [
                    ['q' => 'Which of these is an input device?', 'options' => ['Printer', 'Scanner', 'Speaker', 'Monitor'], 'correct' => 1],
                ],
                'Computer Security' => [
                    ['q' => 'What is a strong password most likely to include?', 'options' => ['Your name only', 'A mix of letters, numbers and symbols', 'The word "password"', 'Your date of birth'], 'correct' => 1],
                ],
            ],

            'General Knowledge' => [
                'World Geography' => [
                    ['q' => 'Which is the largest ocean on Earth?', 'options' => ['Atlantic Ocean', 'Indian Ocean', 'Pacific Ocean', 'Arctic Ocean'], 'correct' => 2],
                    ['q' => 'Which is the longest river in the world?', 'options' => ['Amazon', 'Nile', 'Yangtze', 'Indus'], 'correct' => 1],
                    ['q' => 'Mount Everest lies on the border of Nepal and which country?', 'options' => ['India', 'China', 'Bhutan', 'Pakistan'], 'correct' => 1],
                ],
                'Pakistan Studies' => [
                    ['q' => 'What is the capital city of Pakistan?', 'options' => ['Karachi', 'Lahore', 'Islamabad', 'Peshawar'], 'correct' => 2],
                    ['q' => 'In which year did Pakistan gain independence?', 'options' => ['1940', '1947', '1956', '1971'], 'correct' => 1],
                    ['q' => 'Which is the highest peak in Pakistan?', 'options' => ['Nanga Parbat', 'K2', 'Tirich Mir', 'Rakaposhi'], 'correct' => 1],
                ],
                'Science & Nature' => [
                    ['q' => 'Which gas do plants absorb during photosynthesis?', 'options' => ['Oxygen', 'Carbon dioxide', 'Nitrogen', 'Hydrogen'], 'correct' => 1],
                    ['q' => 'What is the chemical symbol for gold?', 'options' => ['Go', 'Gd', 'Au', 'Ag'], 'correct' => 2],
                ],
            ],

            'Computer Networks' => [
                'Network Fundamentals' => [
                    ['q' => 'What does LAN stand for?', 'options' => ['Local Area Network', 'Long Access Node', 'Linked Array Network', 'Logical Area Name'], 'correct' => 0],
                    ['q' => 'Which topology connects every device to a central hub or switch?', 'options' => ['Ring', 'Bus', 'Star', 'Mesh'], 'correct' => 2],
                ],
                'OSI & TCP/IP Models' => [
                    ['q' => 'How many layers does the OSI model have?', 'options' => ['4', '5', '7', '8'], 'correct' => 2],
                    ['q' => 'Which OSI layer is responsible for routing?', 'options' => ['Data link layer', 'Network layer', 'Transport layer', 'Session layer'], 'correct' => 1],
                    ['q' => 'Which layer of the OSI model is the lowest?', 'options' => ['Physical', 'Data link', 'Network', 'Application'], 'correct' => 0],
                ],
                'Network Layer & IP Addressing' => [
                    ['q' => 'How many bits are in an IPv4 address?', 'options' => ['16', '32', '64', '128'], 'correct' => 1],
                    ['q' => 'Which of these is a private IPv4 address range?', 'options' => ['8.8.8.0/24', '192.168.0.0/16', '203.0.113.0/24', '1.1.1.0/24'], 'correct' => 1],
                ],
                'Transport Layer' => [
                    ['q' => 'Which transport protocol is connection-oriented and reliable?', 'options' => ['UDP', 'TCP', 'ICMP', 'ARP'], 'correct' => 1],
                ],
                'Application Layer Protocols' => [
                    ['q' => 'Which protocol translates domain names into IP addresses?', 'options' => ['DHCP', 'DNS', 'FTP', 'SMTP'], 'correct' => 1],
                    ['q' => 'Which port does HTTPS use by default?', 'options' => ['21', '80', '443', '8080'], 'correct' => 2],
                ],
            ],

            'Data Structure & Algorithm' => [
                'Arrays & Linked Lists' => [
                    ['q' => 'What is the time complexity of accessing an element of an array by index?', 'options' => ['O(1)', 'O(log n)', 'O(n)', 'O(n log n)'], 'correct' => 0],
                    ['q' => 'Which advantage does a linked list have over an array?', 'options' => ['Constant-time random access', 'Easier insertion and deletion', 'Less memory per element', 'Better cache locality'], 'correct' => 1],
                ],
                'Stacks & Queues' => [
                    ['q' => 'A stack follows which order?', 'options' => ['FIFO', 'LIFO', 'Random', 'Priority'], 'correct' => 1],
                    ['q' => 'A queue follows which order?', 'options' => ['LIFO', 'FIFO', 'Sorted', 'Circular only'], 'correct' => 1],
                ],
                'Trees & Binary Search Trees' => [
                    ['q' => 'In a binary search tree, values smaller than a node are stored...', 'options' => ['In the right subtree', 'In the left subtree', 'At the root', 'Anywhere'], 'correct' => 1],
                    ['q' => 'Which traversal of a BST visits nodes in sorted order?', 'options' => ['Pre-order', 'In-order', 'Post-order', 'Level-order'], 'correct' => 1],
                ],
                'Sorting Algorithms' => [
                    ['q' => 'What is the average time complexity of Quick Sort?', 'options' => ['O(n)', 'O(n log n)', 'O(n^2)', 'O(log n)'], 'correct' => 1],
                    ['q' => 'Which sorting algorithm has O(n^2) worst-case and is simplest to implement?', 'options' => ['Merge sort', 'Bubble sort', 'Heap sort', 'Radix sort'], 'correct' => 1],
                ],
                'Searching & Hashing' => [
                    ['q' => 'Binary search requires the data to be...', 'options' => ['Unsorted', 'Sorted', 'Hashed', 'Linked'], 'correct' => 1],
                ],
            ],

            'Design & Analysis of Algorithms' => [
                'Asymptotic Notation' => [
                    ['q' => 'Big-O notation describes which bound?', 'options' => ['Lower bound', 'Upper bound', 'Exact bound only', 'Average bound only'], 'correct' => 1],
                    ['q' => 'Which growth rate is fastest as n becomes large?', 'options' => ['O(log n)', 'O(n)', 'O(n log n)', 'O(2^n)'], 'correct' => 3],
                ],
                'Divide & Conquer' => [
                    ['q' => 'Which algorithm is a classic divide and conquer example?', 'options' => ['Bubble sort', 'Merge sort', 'Linear search', 'Counting sort'], 'correct' => 1],
                ],
                'Greedy Algorithms' => [
                    ['q' => 'Which algorithm uses a greedy strategy for minimum spanning trees?', 'options' => ['Kruskal\'s algorithm', 'Floyd-Warshall', 'Bellman-Ford', 'Quick sort'], 'correct' => 0],
                ],
                'Dynamic Programming' => [
                    ['q' => 'Dynamic programming is most useful when a problem has...', 'options' => ['No repeated subproblems', 'Overlapping subproblems and optimal substructure', 'Only one possible solution', 'Random input only'], 'correct' => 1],
                    ['q' => 'Which problem is a standard dynamic programming example?', 'options' => ['0/1 Knapsack', 'Linear search', 'Bubble sort', 'Binary search'], 'correct' => 0],
                ],
                'Graph Algorithms' => [
                    ['q' => 'Dijkstra\'s algorithm finds...', 'options' => ['A minimum spanning tree', 'Shortest paths from a single source', 'All cycles in a graph', 'The graph diameter only'], 'correct' => 1],
                ],
            ],

            'Object Oriented Programming (OOP)' => [
                'OOP Concepts' => [
                    ['q' => 'Which of these is NOT a pillar of OOP?', 'options' => ['Encapsulation', 'Inheritance', 'Compilation', 'Polymorphism'], 'correct' => 2],
                    ['q' => 'What is abstraction in OOP?', 'options' => ['Hiding implementation details and showing only essential features', 'Copying one class into another', 'Compiling code faster', 'Storing data in files'], 'correct' => 0],
                ],
                'Classes & Objects' => [
                    ['q' => 'A class is best described as...', 'options' => ['An instance of an object', 'A blueprint for creating objects', 'A running process', 'A data file'], 'correct' => 1],
                ],
                'Encapsulation & Abstraction' => [
                    ['q' => 'Which access specifier hides a member from outside the class?', 'options' => ['public', 'private', 'global', 'external'], 'correct' => 1],
                ],
                'Inheritance' => [
                    ['q' => 'Inheritance mainly promotes...', 'options' => ['Code reuse', 'Slower execution', 'Duplicate code', 'Data loss'], 'correct' => 0],
                ],
                'Polymorphism' => [
                    ['q' => 'Function overloading is an example of which polymorphism?', 'options' => ['Runtime polymorphism', 'Compile-time polymorphism', 'No polymorphism', 'Dynamic binding'], 'correct' => 1],
                ],
                'Constructors & Destructors' => [
                    ['q' => 'When is a constructor called?', 'options' => ['When an object is destroyed', 'When an object is created', 'Only on program exit', 'Only when inherited'], 'correct' => 1],
                ],
            ],

            'Web Programming' => [
                'Web Fundamentals' => [
                    ['q' => 'What does URL stand for?', 'options' => ['Uniform Resource Locator', 'Universal Reference Link', 'User Request Line', 'Unified Router Location'], 'correct' => 0],
                    ['q' => 'Which protocol secures web traffic with encryption?', 'options' => ['HTTP', 'HTTPS', 'FTP', 'SMTP'], 'correct' => 1],
                ],
                'Client-Side Scripting' => [
                    ['q' => 'Which language runs in the browser to make pages interactive?', 'options' => ['PHP', 'JavaScript', 'SQL', 'C#'], 'correct' => 1],
                ],
                'Server-Side Basics' => [
                    ['q' => 'Which HTTP method is normally used to submit form data that changes server state?', 'options' => ['GET', 'POST', 'HEAD', 'OPTIONS'], 'correct' => 1],
                    ['q' => 'What does an HTTP status code of 404 mean?', 'options' => ['Server error', 'Not found', 'Unauthorised', 'Success'], 'correct' => 1],
                ],
                'Sessions & Security' => [
                    ['q' => 'Which attack injects malicious SQL through user input?', 'options' => ['XSS', 'SQL injection', 'Phishing', 'DDoS'], 'correct' => 1],
                ],
            ],

            'MS Excel Learning' => [
                'Excel Interface & Basics' => [
                    ['q' => 'What is the intersection of a row and a column called?', 'options' => ['Range', 'Cell', 'Sheet', 'Table'], 'correct' => 1],
                    ['q' => 'What is the default file extension of a modern Excel workbook?', 'options' => ['.xls', '.xlsx', '.csv', '.doc'], 'correct' => 1],
                ],
                'Formulas & Functions' => [
                    ['q' => 'Which symbol must every Excel formula begin with?', 'options' => ['+', '=', '#', '@'], 'correct' => 1],
                    ['q' => 'Which function adds a range of numbers?', 'options' => ['TOTAL()', 'SUM()', 'ADD()', 'PLUS()'], 'correct' => 1],
                    ['q' => 'Which function returns the number of cells that contain numbers?', 'options' => ['COUNT()', 'COUNTA()', 'SUM()', 'LEN()'], 'correct' => 0],
                    ['q' => 'What does the "$" sign do in the reference $A$1?', 'options' => ['Formats as currency', 'Makes the reference absolute', 'Hides the cell', 'Locks the sheet'], 'correct' => 1],
                ],
                'Charts & Graphs' => [
                    ['q' => 'Which chart type is best for showing parts of a whole?', 'options' => ['Line chart', 'Pie chart', 'Scatter chart', 'Gantt chart'], 'correct' => 1],
                ],
                'Sorting, Filtering & Pivot Tables' => [
                    ['q' => 'What is a pivot table mainly used for?', 'options' => ['Printing a sheet', 'Summarising and grouping large data sets', 'Changing fonts', 'Protecting a workbook'], 'correct' => 1],
                ],
            ],

            'MS Word Learning' => [
                'Word Interface & Basics' => [
                    ['q' => 'What is the default file extension of a modern Word document?', 'options' => ['.doc', '.docx', '.txt', '.rtf'], 'correct' => 1],
                    ['q' => 'Which shortcut saves the current document?', 'options' => ['Ctrl + P', 'Ctrl + S', 'Ctrl + V', 'Ctrl + Z'], 'correct' => 1],
                ],
                'Text Formatting' => [
                    ['q' => 'Which shortcut makes selected text bold?', 'options' => ['Ctrl + B', 'Ctrl + I', 'Ctrl + U', 'Ctrl + D'], 'correct' => 0],
                    ['q' => 'Which shortcut undoes the last action?', 'options' => ['Ctrl + Y', 'Ctrl + Z', 'Ctrl + X', 'Ctrl + A'], 'correct' => 1],
                ],
                'Paragraphs & Styles' => [
                    ['q' => 'What is the main benefit of using built-in styles?', 'options' => ['Consistent formatting and automatic table of contents', 'Smaller file size only', 'Faster printing only', 'It disables spell check'], 'correct' => 0],
                ],
                'Mail Merge & Review Tools' => [
                    ['q' => 'Mail merge is used to...', 'options' => ['Combine two documents into one page', 'Create personalised copies of a document from a data list', 'Send email attachments only', 'Merge two tables'], 'correct' => 1],
                    ['q' => 'Which feature records edits so they can be accepted or rejected?', 'options' => ['Track Changes', 'Mail Merge', 'Page Layout', 'Quick Parts'], 'correct' => 0],
                ],
            ],

            'Photoshop Learning' => [
                'Photoshop Interface & Tools' => [
                    ['q' => 'What is Photoshop\'s native layered file format?', 'options' => ['.jpg', '.psd', '.png', '.gif'], 'correct' => 1],
                    ['q' => 'Which tool is used to sample a colour from an image?', 'options' => ['Eyedropper', 'Lasso', 'Clone stamp', 'Dodge'], 'correct' => 0],
                ],
                'Layers & Masks' => [
                    ['q' => 'What does a layer mask let you do?', 'options' => ['Permanently delete pixels', 'Hide or reveal parts of a layer without deleting them', 'Change the file format', 'Lock the canvas size'], 'correct' => 1],
                    ['q' => 'On a layer mask, painting with black does what?', 'options' => ['Reveals the layer', 'Hides the layer', 'Deletes the mask', 'Inverts colours'], 'correct' => 1],
                ],
                'Selection Tools' => [
                    ['q' => 'Which tool selects areas of similar colour with one click?', 'options' => ['Magic Wand', 'Brush', 'Gradient', 'Crop'], 'correct' => 0],
                ],
                'Retouching & Healing' => [
                    ['q' => 'Which tool is designed to remove blemishes by blending surrounding pixels?', 'options' => ['Healing Brush', 'Paint Bucket', 'Type tool', 'Move tool'], 'correct' => 0],
                ],
                'Saving & Exporting' => [
                    ['q' => 'Which format supports transparency and lossless compression?', 'options' => ['JPEG', 'PNG', 'BMP', 'TIFF only'], 'correct' => 1],
                ],
            ],
        ];
    }
}
