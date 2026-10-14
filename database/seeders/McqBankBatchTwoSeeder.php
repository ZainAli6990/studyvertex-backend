<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Batch 2 of the question bank -- deepens the subjects students open
 * most, on top of McqTechSeeder / McqBoardSeeder. Safe to re-run:
 * questions are matched on (topic, question text).
 */
class McqBankBatchTwoSeeder extends Seeder
{
    use SeedsMcqs;

    public function run(): void
    {
        $this->seedBank($this->bank());
    }

    private function bank(): array
    {
        return [
            'C++ (OOP)' => [
                'C++ Basics' => [
                    ['q' => 'Which namespace holds cout and cin?', 'options' => ['io', 'std', 'sys', 'base'], 'correct' => 1],
                    ['q' => 'Which operator is used to read input into a variable with cin?', 'options' => ['<<', '>>', '->', '::'], 'correct' => 1],
                    ['q' => 'What is the value of a bool that stores 0?', 'options' => ['true', 'false', 'null', 'Undefined'], 'correct' => 1],
                ],
                'C++ Object-Oriented Programming' => [
                    ['q' => 'Which keyword makes a base class function overridable at runtime?', 'options' => ['static', 'virtual', 'const', 'friend'], 'correct' => 1],
                    ['q' => 'What is the default access specifier for members of a C++ class?', 'options' => ['public', 'private', 'protected', 'internal'], 'correct' => 1],
                    ['q' => 'A class that cannot be instantiated because it has a pure virtual function is called...', 'options' => ['A final class', 'An abstract class', 'A static class', 'A nested class'], 'correct' => 1],
                ],
                'C++ Functions' => [
                    ['q' => 'What does a function signature consist of?', 'options' => ['Only the return type', 'The name and the parameter list', 'Only the body', 'The file name'], 'correct' => 1],
                ],
            ],

            'Speaking English Skills' => [
                'Formal & Informal Speech' => [
                    ['q' => 'Which is the informal version of "Please find attached the report"?', 'options' => ['"The report is enclosed herewith"', '"Here\'s the report"', '"Kindly locate the attachment"', '"Attached please find"'], 'correct' => 1],
                    ['q' => 'Which greeting fits an email to a manager you have never met?', 'options' => ['"Hey!"', '"Dear Mr Khan,"', '"Yo boss,"', '"Hiya,"'], 'correct' => 1],
                    ['q' => 'Which is the formal way to say "I can\'t make it"?', 'options' => ['"No chance"', '"I am unable to attend"', '"Not happening"', '"Count me out"'], 'correct' => 1],
                ],
                'Everyday Conversation' => [
                    ['q' => 'Someone says "Thanks a lot!" — which reply is natural?', 'options' => ['"You\'re welcome."', '"Yes please."', '"I don\'t know."', '"Good morning."'], 'correct' => 0],
                    ['q' => 'What does "I\'m running late" mean?', 'options' => ['I am exercising', 'I will arrive after the expected time', 'I am leaving early', 'I am in a race'], 'correct' => 1],
                    ['q' => 'Which sentence politely interrupts a conversation?', 'options' => ['"Stop talking."', '"Sorry to interrupt, but…"', '"Listen to me now."', '"Be quiet."'], 'correct' => 1],
                ],
                'Common Phrases & Idioms' => [
                    ['q' => 'What does "hit the books" mean?', 'options' => ['To study hard', 'To throw something', 'To buy novels', 'To stop reading'], 'correct' => 0],
                    ['q' => 'What does "under the weather" mean?', 'options' => ['Feeling unwell', 'Standing outside', 'Very happy', 'Extremely busy'], 'correct' => 0],
                    ['q' => 'What does "call it a day" mean?', 'options' => ['To start work', 'To stop work for the day', 'To name a date', 'To plan a holiday'], 'correct' => 1],
                ],
                'Pronunciation & Stress' => [
                    ['q' => 'In the noun "PREsent", which syllable is stressed?', 'options' => ['The first', 'The second', 'Both equally', 'Neither'], 'correct' => 0],
                    ['q' => 'Which word has a silent letter?', 'options' => ['table', 'knife', 'water', 'paper'], 'correct' => 1],
                ],
                'Asking Questions' => [
                    ['q' => 'Which is the correct question form?', 'options' => ['"Where you are going?"', '"Where are you going?"', '"Where going you are?"', '"You are going where?"'], 'correct' => 1],
                    ['q' => 'Which question asks for a reason?', 'options' => ['"When did it happen?"', '"Why did it happen?"', '"Where did it happen?"', '"Who saw it?"'], 'correct' => 1],
                ],
                'Telephone & Email English' => [
                    ['q' => 'How do you politely ask a caller to wait?', 'options' => ['"Hold on, I said."', '"Could you hold the line, please?"', '"Wait."', '"Don\'t go anywhere."'], 'correct' => 1],
                    ['q' => 'Which closing suits a formal email?', 'options' => ['"Cheers!"', '"Yours sincerely,"', '"Later,"', '"Bye bye"'], 'correct' => 1],
                ],
                'Greetings & Introductions' => [
                    ['q' => 'How do you introduce a colleague formally?', 'options' => ['"This is my friend, I guess."', '"May I introduce my colleague, Sara?"', '"Meet Sara, whatever."', '"Sara. Done."'], 'correct' => 1],
                ],
                'Interview English' => [
                    ['q' => 'Which is the best answer to "What is your weakness?"', 'options' => ['"I have none."', '"I used to struggle with X, and here is how I improved."', '"Everything."', '"I would rather not say."'], 'correct' => 1],
                ],
            ],

            'HTML' => [
                'Lists & Tables' => [
                    ['q' => 'Which tag creates an unordered list?', 'options' => ['<ol>', '<ul>', '<li>', '<dl>'], 'correct' => 1],
                    ['q' => 'Which tag defines a row inside a table?', 'options' => ['<td>', '<tr>', '<th>', '<table-row>'], 'correct' => 1],
                    ['q' => 'Which tag marks a table header cell?', 'options' => ['<td>', '<th>', '<thead>', '<header>'], 'correct' => 1],
                ],
                'Semantic HTML5' => [
                    ['q' => 'Which tag represents the main navigation of a page?', 'options' => ['<menu>', '<nav>', '<links>', '<bar>'], 'correct' => 1],
                    ['q' => 'Which HTML5 tag represents self-contained content such as a blog post?', 'options' => ['<section>', '<article>', '<div>', '<aside>'], 'correct' => 1],
                ],
                'HTML Basics & Structure' => [
                    ['q' => 'Which tag holds meta information and the page title?', 'options' => ['<body>', '<head>', '<main>', '<top>'], 'correct' => 1],
                ],
                'Forms & Inputs' => [
                    ['q' => 'Which attribute makes a form field compulsory?', 'options' => ['must', 'required', 'validate', 'check'], 'correct' => 1],
                ],
            ],

            'CSS (Cascading Style Sheets)' => [
                'Colors, Fonts & Text' => [
                    ['q' => 'Which property sets the size of text?', 'options' => ['text-size', 'font-size', 'size', 'font-scale'], 'correct' => 1],
                    ['q' => 'In the colour code #FF0000, which colour is represented?', 'options' => ['Green', 'Blue', 'Red', 'Black'], 'correct' => 2],
                ],
                'Responsive Design' => [
                    ['q' => 'Which CSS at-rule applies styles based on screen width?', 'options' => ['@import', '@media', '@font-face', '@screen'], 'correct' => 1],
                    ['q' => 'Which unit is relative to the root element\'s font size?', 'options' => ['px', 'em', 'rem', 'pt'], 'correct' => 2],
                ],
                'Transitions & Animations' => [
                    ['q' => 'Which property defines the steps of a CSS animation?', 'options' => ['@keyframes', 'transition', 'transform', 'animate'], 'correct' => 0],
                ],
                'Selectors & Specificity' => [
                    ['q' => 'Which symbol selects elements by class name?', 'options' => ['#', '.', ':', '>'], 'correct' => 1],
                ],
            ],

            'JavaScript' => [
                'Functions & Scope' => [
                    ['q' => 'What does an arrow function NOT have its own binding of?', 'options' => ['Parameters', '"this"', 'Return value', 'Name'], 'correct' => 1],
                    ['q' => 'A variable declared with "let" inside a block is visible...', 'options' => ['Everywhere in the file', 'Only inside that block', 'Only inside functions', 'Only globally'], 'correct' => 1],
                ],
                'Events & Asynchronous JS' => [
                    ['q' => 'Which method attaches an event handler to an element?', 'options' => ['addEventListener()', 'attachEvent()', 'onEvent()', 'bindEvent()'], 'correct' => 0],
                    ['q' => 'Which keyword waits for a promise to settle inside an async function?', 'options' => ['wait', 'await', 'hold', 'defer'], 'correct' => 1],
                    ['q' => 'What does a Promise represent?', 'options' => ['A finished value only', 'The eventual result of an asynchronous operation', 'A CSS rule', 'A DOM node'], 'correct' => 1],
                ],
                'Arrays & Objects' => [
                    ['q' => 'Which method removes the last element of an array?', 'options' => ['pop()', 'push()', 'slice()', 'splice() only'], 'correct' => 0],
                ],
                'JavaScript Basics' => [
                    ['q' => 'JavaScript is best described as a...', 'options' => ['Compiled system language', 'Interpreted scripting language', 'Markup language', 'Database language'], 'correct' => 1],
                ],
            ],

            'Python' => [
                'File Handling & Exceptions' => [
                    ['q' => 'Which mode opens a file for writing and truncates it?', 'options' => ['"r"', '"w"', '"a"', '"x"'], 'correct' => 1],
                    ['q' => 'Which block handles an exception in Python?', 'options' => ['catch', 'except', 'rescue', 'handle'], 'correct' => 1],
                    ['q' => 'Which statement closes a file automatically after use?', 'options' => ['with open(...)', 'open(...)', 'file(...)', 'auto open(...)'], 'correct' => 0],
                ],
                'Object-Oriented Python' => [
                    ['q' => 'Which method acts as the constructor of a Python class?', 'options' => ['__start__', '__init__', '__new__ only', '__create__'], 'correct' => 1],
                    ['q' => 'What does "self" refer to in a Python method?', 'options' => ['The class itself', 'The current instance', 'The parent class', 'The module'], 'correct' => 1],
                ],
                'Lists, Tuples & Dictionaries' => [
                    ['q' => 'How do you access the value of key "a" in dictionary d?', 'options' => ['d.a()', "d['a']", 'd->a', 'd(a)'], 'correct' => 1],
                    ['q' => 'What does len([1, 2, 3]) return?', 'options' => ['2', '3', '4', 'Error'], 'correct' => 1],
                ],
            ],

            'Java (OOP)' => [
                'Data Types & Operators' => [
                    ['q' => 'Which of these is a primitive data type in Java?', 'options' => ['String', 'int', 'Array', 'Object'], 'correct' => 1],
                    ['q' => 'How many bits does a Java "int" use?', 'options' => ['8', '16', '32', '64'], 'correct' => 2],
                ],
                'Methods & Arrays' => [
                    ['q' => 'What is the index of the first element of a Java array?', 'options' => ['0', '1', '-1', 'Depends on the type'], 'correct' => 0],
                    ['q' => 'Which field gives the size of a Java array?', 'options' => ['size', 'length', 'count', 'len()'], 'correct' => 1],
                ],
                'Control Flow' => [
                    ['q' => 'Which loop is best when the number of repetitions is known?', 'options' => ['while', 'do-while', 'for', 'if'], 'correct' => 2],
                ],
            ],

            'Computer Basics' => [
                'Internet & Networking Basics' => [
                    ['q' => 'What does WWW stand for?', 'options' => ['World Wide Web', 'Wide Web World', 'Web Wire Work', 'World Web Window'], 'correct' => 0],
                    ['q' => 'Which device is needed to connect a home to the internet?', 'options' => ['Modem/router', 'Scanner', 'Projector', 'Plotter'], 'correct' => 0],
                    ['q' => 'An email address always contains which symbol?', 'options' => ['#', '@', '&', '%'], 'correct' => 1],
                ],
                'Computer Security' => [
                    ['q' => 'What is a computer virus?', 'options' => ['A hardware fault', 'A malicious program that spreads and damages data', 'A type of printer', 'A network cable'], 'correct' => 1],
                    ['q' => 'What does a firewall do?', 'options' => ['Cools the CPU', 'Filters incoming and outgoing network traffic', 'Increases RAM', 'Cleans the screen'], 'correct' => 1],
                ],
                'Input & Output Devices' => [
                    ['q' => 'Which device is both an input and an output device?', 'options' => ['Mouse', 'Touch screen', 'Speaker', 'Keyboard'], 'correct' => 1],
                ],
            ],

            'General Knowledge' => [
                'World History' => [
                    ['q' => 'In which year did the Second World War end?', 'options' => ['1918', '1939', '1945', '1950'], 'correct' => 2],
                    ['q' => 'Who was the first President of the United States?', 'options' => ['Abraham Lincoln', 'George Washington', 'Thomas Jefferson', 'John Adams'], 'correct' => 1],
                ],
                'Sports & Games' => [
                    ['q' => 'How many players are there in a cricket team on the field?', 'options' => ['9', '10', '11', '12'], 'correct' => 2],
                    ['q' => 'How often are the Summer Olympic Games normally held?', 'options' => ['Every 2 years', 'Every 3 years', 'Every 4 years', 'Every 5 years'], 'correct' => 2],
                ],
                'Current Affairs & Organisations' => [
                    ['q' => 'Where is the headquarters of the United Nations located?', 'options' => ['Geneva', 'New York', 'Paris', 'Vienna'], 'correct' => 1],
                    ['q' => 'What does WHO stand for?', 'options' => ['World Health Organization', 'World Housing Office', 'Wide Health Operation', 'World Heritage Organization'], 'correct' => 0],
                ],
                'World Geography' => [
                    ['q' => 'Which is the largest desert in the world?', 'options' => ['Sahara', 'Gobi', 'Antarctic Desert', 'Thar'], 'correct' => 2],
                ],
            ],

            'Computer Networks' => [
                'Physical & Data Link Layer' => [
                    ['q' => 'A MAC address operates at which OSI layer?', 'options' => ['Physical', 'Data link', 'Network', 'Transport'], 'correct' => 1],
                    ['q' => 'How many bits are in a MAC address?', 'options' => ['32', '48', '64', '128'], 'correct' => 1],
                ],
                'Network Security' => [
                    ['q' => 'What does VPN stand for?', 'options' => ['Virtual Private Network', 'Verified Public Node', 'Variable Packet Number', 'Virtual Port Name'], 'correct' => 0],
                ],
                'Network Fundamentals' => [
                    ['q' => 'Which device forwards data only to the intended port on a LAN?', 'options' => ['Hub', 'Switch', 'Repeater', 'Splitter'], 'correct' => 1],
                ],
                'Transport Layer' => [
                    ['q' => 'Which protocol is connectionless and faster but unreliable?', 'options' => ['TCP', 'UDP', 'FTP', 'HTTP'], 'correct' => 1],
                ],
            ],

            'Data Structure & Algorithm' => [
                'Complexity Analysis' => [
                    ['q' => 'What is the time complexity of binary search on a sorted array?', 'options' => ['O(1)', 'O(log n)', 'O(n)', 'O(n^2)'], 'correct' => 1],
                    ['q' => 'What is the time complexity of a linear search in the worst case?', 'options' => ['O(1)', 'O(log n)', 'O(n)', 'O(n log n)'], 'correct' => 2],
                ],
                'Graphs & Traversal' => [
                    ['q' => 'Which data structure does breadth-first search use?', 'options' => ['Stack', 'Queue', 'Heap', 'Tree only'], 'correct' => 1],
                    ['q' => 'Which data structure does depth-first search typically use?', 'options' => ['Queue', 'Stack', 'Hash table', 'Array only'], 'correct' => 1],
                ],
                'Searching & Hashing' => [
                    ['q' => 'What is a hash collision?', 'options' => ['Two keys mapping to the same index', 'A key with no value', 'A full array', 'A deleted record'], 'correct' => 0],
                ],
            ],

            'MS Excel Learning' => [
                'Cells, Rows & Columns' => [
                    ['q' => 'What is the address of the cell in column B, row 5?', 'options' => ['5B', 'B5', 'B:5', 'BR5'], 'correct' => 1],
                    ['q' => 'Which shortcut inserts the current date in Excel?', 'options' => ['Ctrl + D', 'Ctrl + ;', 'Ctrl + T', 'Ctrl + N'], 'correct' => 1],
                ],
                'Formulas & Functions' => [
                    ['q' => 'Which function returns the largest value in a range?', 'options' => ['TOP()', 'MAX()', 'HIGH()', 'LARGE() only'], 'correct' => 1],
                    ['q' => 'Which function looks up a value in the first column of a table?', 'options' => ['VLOOKUP()', 'HLOOKUP()', 'FINDCOL()', 'SEARCH()'], 'correct' => 0],
                ],
                'Formatting & Styles' => [
                    ['q' => 'What does conditional formatting do?', 'options' => ['Formats cells automatically based on their values', 'Locks the sheet', 'Creates a chart', 'Sorts data'], 'correct' => 0],
                ],
            ],

            '1st Year Physics' => [
                'Circular Motion' => [
                    ['q' => 'The force that keeps a body moving in a circle is called...', 'options' => ['Centrifugal force', 'Centripetal force', 'Frictional force', 'Normal force'], 'correct' => 1],
                    ['q' => 'The SI unit of angular velocity is...', 'options' => ['m/s', 'rad/s', 'rev', 'Hz only'], 'correct' => 1],
                ],
                'Fluid Dynamics' => [
                    ['q' => 'Bernoulli\'s equation is based on the conservation of...', 'options' => ['Charge', 'Energy', 'Mass only', 'Momentum only'], 'correct' => 1],
                ],
                'Thermodynamics' => [
                    ['q' => 'The first law of thermodynamics is a statement of conservation of...', 'options' => ['Mass', 'Energy', 'Charge', 'Volume'], 'correct' => 1],
                    ['q' => 'What is absolute zero on the Celsius scale?', 'options' => ['0 °C', '-100 °C', '-273 °C', '-373 °C'], 'correct' => 2],
                ],
                'Measurements' => [
                    ['q' => 'Which is the SI unit of the amount of substance?', 'options' => ['Gram', 'Mole', 'Litre', 'Kelvin'], 'correct' => 1],
                ],
            ],

            '1st Year Biology' => [
                'Variety of Life & Kingdoms' => [
                    ['q' => 'How many kingdoms are there in the five-kingdom classification?', 'options' => ['3', '4', '5', '6'], 'correct' => 2],
                    ['q' => 'Bacteria belong to which kingdom in the five-kingdom system?', 'options' => ['Monera', 'Protista', 'Fungi', 'Plantae'], 'correct' => 0],
                ],
                'Nutrition & Digestion' => [
                    ['q' => 'Where does most of the absorption of digested food occur?', 'options' => ['Stomach', 'Small intestine', 'Large intestine', 'Oesophagus'], 'correct' => 1],
                    ['q' => 'Which enzyme in saliva begins starch digestion?', 'options' => ['Pepsin', 'Amylase', 'Lipase', 'Trypsin'], 'correct' => 1],
                ],
                'The Cell' => [
                    ['q' => 'Who first observed and named cells?', 'options' => ['Robert Hooke', 'Louis Pasteur', 'Gregor Mendel', 'Charles Darwin'], 'correct' => 0],
                ],
            ],

            '1st Year Chemistry' => [
                'Thermochemistry' => [
                    ['q' => 'A reaction that releases heat is called...', 'options' => ['Endothermic', 'Exothermic', 'Isothermal', 'Adiabatic'], 'correct' => 1],
                ],
                'Chemical Equilibrium' => [
                    ['q' => 'At equilibrium, the rates of the forward and reverse reactions are...', 'options' => ['Zero', 'Equal', 'Always increasing', 'Unrelated'], 'correct' => 1],
                ],
                'Atomic Structure' => [
                    ['q' => 'Isotopes of an element have the same number of protons but different numbers of...', 'options' => ['Electrons', 'Neutrons', 'Shells', 'Orbitals'], 'correct' => 1],
                ],
            ],

            '2nd Year Physics' => [
                'Electromagnetic Induction' => [
                    ['q' => 'Faraday\'s law relates induced EMF to the rate of change of...', 'options' => ['Current', 'Magnetic flux', 'Resistance', 'Charge'], 'correct' => 1],
                    ['q' => 'Lenz\'s law is a consequence of the conservation of...', 'options' => ['Charge', 'Energy', 'Mass', 'Momentum'], 'correct' => 1],
                ],
                'Alternating Current' => [
                    ['q' => 'What is the frequency of the AC mains supply in Pakistan?', 'options' => ['40 Hz', '50 Hz', '60 Hz', '100 Hz'], 'correct' => 1],
                ],
                'Current Electricity' => [
                    ['q' => 'The SI unit of electric current is the...', 'options' => ['Volt', 'Ampere', 'Coulomb', 'Ohm'], 'correct' => 1],
                ],
            ],

            '2nd Year Biology' => [
                'Reproduction' => [
                    ['q' => 'The fusion of a male and a female gamete is called...', 'options' => ['Mitosis', 'Fertilisation', 'Budding', 'Fission'], 'correct' => 1],
                ],
                'Growth & Development' => [
                    ['q' => 'Which type of cell division produces gametes?', 'options' => ['Mitosis', 'Meiosis', 'Binary fission', 'Budding'], 'correct' => 1],
                ],
                'Inheritance & Genetics' => [
                    ['q' => 'DNA stands for...', 'options' => ['Deoxyribonucleic acid', 'Dinucleic acid', 'Double nuclear acid', 'Deoxyribose nitrogen acid'], 'correct' => 0],
                ],
            ],

            '1st Year English' => [
                'Idioms & Prepositions' => [
                    ['q' => 'Fill in the blank: "He is good ___ mathematics."', 'options' => ['in', 'at', 'on', 'for'], 'correct' => 1],
                    ['q' => 'Fill in the blank: "She has been ill ___ Monday."', 'options' => ['for', 'since', 'from', 'by'], 'correct' => 1],
                ],
                'Parts of Speech' => [
                    ['q' => 'Which word is a conjunction?', 'options' => ['and', 'quickly', 'blue', 'table'], 'correct' => 0],
                ],
                'Comprehension & Textbook' => [
                    ['q' => 'What is the main purpose of a topic sentence in a paragraph?', 'options' => ['To end the paragraph', 'To state the paragraph\'s main idea', 'To add a quotation', 'To list references'], 'correct' => 1],
                ],
            ],

            '2nd Year Pak Study (Eng)' => [
                'Economy & Resources' => [
                    ['q' => 'Which crop is the main cash crop of Pakistan?', 'options' => ['Cotton', 'Tea', 'Coffee', 'Rubber'], 'correct' => 0],
                    ['q' => 'Which dam is built on the River Indus?', 'options' => ['Mangla Dam', 'Tarbela Dam', 'Warsak Dam', 'Hub Dam'], 'correct' => 1],
                ],
                'Foreign Policy' => [
                    ['q' => 'Pakistan became a member of the United Nations in which year?', 'options' => ['1947', '1948', '1950', '1956'], 'correct' => 0],
                ],
            ],

            'Object Oriented Programming (OOP)' => [
                'Polymorphism' => [
                    ['q' => 'Method overriding is an example of which polymorphism?', 'options' => ['Compile-time', 'Runtime', 'Static', 'None'], 'correct' => 1],
                ],
                'Inheritance' => [
                    ['q' => 'The class that is inherited from is called the...', 'options' => ['Child class', 'Base class', 'Nested class', 'Inner class'], 'correct' => 1],
                ],
                'Constructors & Destructors' => [
                    ['q' => 'A destructor is called when an object is...', 'options' => ['Created', 'Copied', 'Destroyed', 'Renamed'], 'correct' => 2],
                ],
            ],
        ];
    }
}
