<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Batch 4 of the MCQ question bank.
 *
 * - Fills every topic that previously showed "0 MCQs" (Kotlin, Node.js, PHP,
 *   Swift, WordPress, DAA, Web Programming, MS Word, Photoshop, 1st/2nd Year
 *   subjects, ...) with starter questions.
 * - Raises Sociology (1st & 2nd Year, Eng + Urdu) and 2nd Year Education
 *   (Eng + Urdu) from 5 questions to 40+ each.
 *
 * Matched on (topic_id, question) via SeedsMcqs, so re-running is safe.
 */
class McqBankBatchFourSeeder extends Seeder
{
    use SeedsMcqs;

    public function run(): void
    {
        $this->seedBank($this->bank());
    }

    private function bank(): array
    {
        return [
            'Kotlin Basic & Advance' => [
                'Control Flow & Loops' => [
                    ['q' => 'Which Kotlin keyword replaces Java\'s switch statement?', 'options' => ['switch', 'when', 'match', 'select'], 'correct' => 1],
                    ['q' => 'Which loop correctly iterates from 1 to 5 (inclusive) in Kotlin?', 'options' => ['for (i in 1..5)', 'for (i = 1; i <= 5)', 'foreach (1..5)', 'loop(1, 5)'], 'correct' => 0],
                    ['q' => 'In Kotlin, \'if\' can be used as:', 'options' => ['A statement only, never returning a value', 'A loop', 'A function declaration', 'An expression that returns a value'], 'correct' => 3],
                    ['q' => 'What does the range \'1 until 5\' produce?', 'options' => ['1, 2, 3, 4, 5', '2, 3, 4, 5', '1, 2, 3, 4 (end excluded)', 'An infinite sequence'], 'correct' => 2],
                    ['q' => 'Which keyword immediately exits the nearest enclosing loop?', 'options' => ['continue', 'break', 'skip', 'pass'], 'correct' => 1],
                ],
                'Collections & Coroutines' => [
                    ['q' => 'Which function creates a read-only list in Kotlin?', 'options' => ['listOf()', 'mutableListOf()', 'arrayList()', 'newList()'], 'correct' => 0],
                    ['q' => 'Which keyword marks a function that can be paused and resumed in a coroutine?', 'options' => ['async', 'pause', 'yield', 'suspend'], 'correct' => 3],
                    ['q' => 'Which coroutine builder blocks the current thread until its work finishes?', 'options' => ['launch', 'async', 'runBlocking', 'withContext'], 'correct' => 2],
                    ['q' => 'What does the \'launch\' coroutine builder return?', 'options' => ['A Deferred value', 'A Job', 'A Thread', 'Unit only'], 'correct' => 1],
                    ['q' => 'Which collection type stores key-value pairs in Kotlin?', 'options' => ['Map', 'List', 'Set', 'Array'], 'correct' => 0],
                ],
            ],
            'Node.js' => [
                'File System & Streams' => [
                    ['q' => 'Which built-in Node.js module is used to work with files?', 'options' => ['http', 'path only', 'os', 'fs'], 'correct' => 3],
                    ['q' => 'What is the difference between fs.readFile and fs.readFileSync?', 'options' => ['readFile blocks; readFileSync is asynchronous', 'They are identical', 'readFile is asynchronous; readFileSync blocks until done', 'readFileSync only works on Windows'], 'correct' => 2],
                    ['q' => 'Which stream type is used to read data piece by piece?', 'options' => ['Writable', 'Readable', 'Duplex only', 'Buffer'], 'correct' => 1],
                    ['q' => 'Which method connects a readable stream to a writable stream?', 'options' => ['pipe()', 'join()', 'attach()', 'link()'], 'correct' => 0],
                    ['q' => 'What is the main advantage of streams for large files?', 'options' => ['Files become smaller', 'They make files read-only', 'They remove the need for the fs module', 'Data is processed in chunks without loading the whole file into memory'], 'correct' => 3],
                ],
                'Asynchronous Node' => [
                    ['q' => 'What lets Node.js handle many I/O operations without blocking?', 'options' => ['Multiple CPU threads for every request', 'Synchronous callbacks only', 'The event loop', 'The garbage collector'], 'correct' => 2],
                    ['q' => 'An async function always returns:', 'options' => ['A callback', 'A Promise', 'undefined', 'A Buffer'], 'correct' => 1],
                    ['q' => 'Which keyword pauses an async function until a Promise settles?', 'options' => ['await', 'yield', 'pause', 'defer'], 'correct' => 0],
                    ['q' => '\'Callback hell\' is best avoided by using:', 'options' => ['More nested callbacks', 'Global variables', 'Synchronous loops only', 'Promises or async/await'], 'correct' => 3],
                    ['q' => 'process.nextTick() callbacks run:', 'options' => ['After 1 second', 'Only when the program exits', 'After the current operation, before the event loop continues', 'Never until setTimeout fires'], 'correct' => 2],
                ],
                'REST APIs & Middleware' => [
                    ['q' => 'Which HTTP method is normally used to create a new resource?', 'options' => ['GET', 'POST', 'DELETE', 'HEAD'], 'correct' => 1],
                    ['q' => 'What is the signature of an Express middleware function?', 'options' => ['(req, res, next)', '(error)', '(app, server)', '(request only)'], 'correct' => 0],
                    ['q' => 'Which function passes control to the next middleware in Express?', 'options' => ['continue()', 'pass()', 'forward()', 'next()'], 'correct' => 3],
                    ['q' => 'Which status code means \'Not Found\'?', 'options' => ['200', '500', '404', '301'], 'correct' => 2],
                    ['q' => 'Which built-in Express middleware parses incoming JSON bodies?', 'options' => ['express.static()', 'express.json()', 'express.router()', 'express.parse()'], 'correct' => 1],
                ],
            ],
            'PHP (Hypertext Preprocessor)' => [
                'Control Structures' => [
                    ['q' => 'Which structure is a clean alternative to a long if-elseif chain on one value?', 'options' => ['switch', 'foreach', 'include', 'goto'], 'correct' => 0],
                    ['q' => 'Which loop always executes its body at least once?', 'options' => ['while', 'for', 'foreach', 'do...while'], 'correct' => 3],
                    ['q' => 'Which keyword skips the rest of the current loop iteration?', 'options' => ['break', 'exit', 'continue', 'return'], 'correct' => 2],
                    ['q' => 'The foreach loop is mainly used to iterate over:', 'options' => ['Only integers', 'Arrays', 'Only strings', 'Files only'], 'correct' => 1],
                    ['q' => 'What does this print? for ($i = 0; $i < 3; $i++) echo $i;', 'options' => ['012', '123', '0123', '321'], 'correct' => 0],
                ],
                'Sessions, Cookies & Files' => [
                    ['q' => 'Which function starts a session in PHP?', 'options' => ['start_session()', 'new_session()', 'begin()', 'session_start()'], 'correct' => 3],
                    ['q' => 'Where is session data stored by default?', 'options' => ['Inside the browser only', 'In the HTML page', 'On the server', 'In a CSS file'], 'correct' => 2],
                    ['q' => 'Which function sets a cookie?', 'options' => ['makecookie()', 'setcookie()', 'cookie_set()', 'savecookie()'], 'correct' => 1],
                    ['q' => 'Which superglobal holds session variables?', 'options' => ['$_SESSION', '$_COOKIE', '$_GET', '$_SERVER'], 'correct' => 0],
                    ['q' => 'Which function reads a whole file into a string?', 'options' => ['fopen_all()', 'read_all()', 'get_file()', 'file_get_contents()'], 'correct' => 3],
                ],
                'PHP with MySQL' => [
                    ['q' => 'Which two PHP extensions are commonly used to connect to MySQL?', 'options' => ['GD and cURL', 'JSON and XML', 'MySQLi and PDO', 'SPL and Intl'], 'correct' => 2],
                    ['q' => 'Which function opens a connection using the procedural MySQLi API?', 'options' => ['mysql_open()', 'mysqli_connect()', 'db_connect()', 'connect_mysql()'], 'correct' => 1],
                    ['q' => 'Prepared statements mainly protect against:', 'options' => ['SQL injection', 'Slow internet', 'CSS errors', 'Browser caching'], 'correct' => 0],
                    ['q' => 'Which SQL command retrieves data from a table?', 'options' => ['INSERT', 'UPDATE', 'DROP', 'SELECT'], 'correct' => 3],
                    ['q' => 'What does mysqli_close() do?', 'options' => ['Deletes the database', 'Closes the browser', 'Closes the database connection', 'Stops the web server'], 'correct' => 2],
                ],
            ],
            'Swift' => [
                'Control Flow' => [
                    ['q' => 'Which statement is true about Swift\'s switch?', 'options' => ['It falls through every case by default', 'It must be exhaustive', 'It only works with integers', 'It cannot have a default case'], 'correct' => 1],
                    ['q' => 'Which syntax loops through every item of an array in Swift?', 'options' => ['for item in array', 'foreach item of array', 'for (item : array)', 'loop array as item'], 'correct' => 0],
                    ['q' => 'What does the \'guard\' statement do?', 'options' => ['Creates a loop', 'Declares a constant', 'Imports a module', 'Exits early when a condition is not met'], 'correct' => 3],
                    ['q' => 'The half-open range operator \'..<\' does what?', 'options' => ['Includes both bounds', 'Excludes the lower bound', 'Excludes the upper bound', 'Creates a descending range'], 'correct' => 2],
                    ['q' => 'Does a Swift switch case fall through to the next case implicitly?', 'options' => ['Yes, always', 'No', 'Only for strings', 'Only with the \'break\' keyword'], 'correct' => 1],
                ],
                'Protocols & Extensions' => [
                    ['q' => 'What does a protocol define in Swift?', 'options' => ['A blueprint of methods and properties', 'A database table', 'A loop structure', 'A memory address'], 'correct' => 0],
                    ['q' => 'Which keyword declares a protocol?', 'options' => ['interface', 'trait', 'contract', 'protocol'], 'correct' => 3],
                    ['q' => 'What can an extension add to an existing type?', 'options' => ['New stored properties', 'A new superclass', 'New functionality such as methods and computed properties', 'Nothing at all'], 'correct' => 2],
                    ['q' => 'Can an extension add stored properties to a type?', 'options' => ['Yes, always', 'No, only computed properties', 'Only for classes', 'Only for enums'], 'correct' => 1],
                    ['q' => 'A type that adopts a protocol must:', 'options' => ['Implement all of its requirements', 'Inherit from NSObject', 'Be a class', 'Use the \'final\' keyword'], 'correct' => 0],
                ],
            ],
            'Wordpress' => [
                'Dashboard & Settings' => [
                    ['q' => 'What is the default URL path to the WordPress admin area?', 'options' => ['/admin-panel', '/dashboard-login', '/wp-config', '/wp-admin'], 'correct' => 3],
                    ['q' => 'Where do you change the Site Title and Tagline?', 'options' => ['Appearance > Themes', 'Plugins > Add New', 'Settings > General', 'Users > Profile'], 'correct' => 2],
                    ['q' => 'Which setting controls the URL structure of posts?', 'options' => ['Discussion', 'Permalinks', 'Media', 'Privacy'], 'correct' => 1],
                    ['q' => 'Which dashboard menu is used to change themes and menus?', 'options' => ['Appearance', 'Tools', 'Comments', 'Users'], 'correct' => 0],
                    ['q' => 'Where can you choose whether the homepage shows latest posts or a static page?', 'options' => ['Settings > Writing', 'Posts > Categories', 'Media > Library', 'Settings > Reading'], 'correct' => 3],
                ],
                'Users, SEO & Security' => [
                    ['q' => 'Which is the highest default user role in WordPress?', 'options' => ['Editor', 'Author', 'Administrator', 'Subscriber'], 'correct' => 2],
                    ['q' => 'Which role can write and publish only their own posts?', 'options' => ['Subscriber', 'Author', 'Contributor', 'Editor'], 'correct' => 1],
                    ['q' => 'Which of these is a popular WordPress SEO plugin?', 'options' => ['Yoast SEO', 'Elementor', 'WooCommerce', 'Akismet'], 'correct' => 0],
                    ['q' => 'Which practice improves WordPress security?', 'options' => ['Using \'admin\' as the username', 'Never updating plugins', 'Sharing the admin login', 'Strong passwords and regular updates'], 'correct' => 3],
                    ['q' => 'Which role can only manage their own profile and read content?', 'options' => ['Administrator', 'Editor', 'Subscriber', 'Author'], 'correct' => 2],
                ],
            ],
            'Design & Analysis of Algorithms' => [
                'Backtracking & Branch and Bound' => [
                    ['q' => 'Backtracking solves a problem by:', 'options' => ['Always choosing the locally best option', 'Building a solution step by step and abandoning paths that fail', 'Splitting input into equal halves', 'Sorting the data first'], 'correct' => 1],
                    ['q' => 'Which classic problem is solved using backtracking?', 'options' => ['N-Queens', 'Binary search', 'Merge sort', 'Linear search'], 'correct' => 0],
                    ['q' => 'Branch and Bound uses what to avoid exploring useless branches?', 'options' => ['Random numbers', 'Recursion only', 'Sorting', 'Bounds'], 'correct' => 3],
                    ['q' => 'Backtracking is closely related to which traversal?', 'options' => ['Breadth-First Search only', 'Level-order traversal', 'Depth-First Search', 'Inorder traversal only'], 'correct' => 2],
                    ['q' => 'Which puzzle is a typical backtracking example?', 'options' => ['Counting sort', 'Sudoku', 'Binary search', 'Bubble sort'], 'correct' => 1],
                ],
                'NP-Completeness' => [
                    ['q' => 'The class P contains problems that can be solved in:', 'options' => ['Polynomial time', 'Exponential time only', 'Constant time only', 'Logarithmic space only'], 'correct' => 0],
                    ['q' => 'The class NP contains problems whose solutions can be:', 'options' => ['Found in linear time', 'Solved without any input', 'Never verified', 'Verified in polynomial time'], 'correct' => 3],
                    ['q' => 'Which problem was the first proven NP-complete (Cook-Levin theorem)?', 'options' => ['Merge sort', 'Binary search', 'Boolean Satisfiability (SAT)', 'Shortest path'], 'correct' => 2],
                    ['q' => 'If any NP-complete problem is solved in polynomial time, then:', 'options' => ['P is empty', 'P = NP', 'NP is empty', 'All algorithms become linear'], 'correct' => 1],
                    ['q' => 'Which of these is NP-complete?', 'options' => ['3-SAT', 'Binary search', 'Merge sort', 'Linear search'], 'correct' => 0],
                ],
            ],
            'Web Programming' => [
                'HTML & CSS Essentials' => [
                    ['q' => 'Which HTML tag creates a hyperlink?', 'options' => ['<link>', '<href>', '<url>', '<a>'], 'correct' => 3],
                    ['q' => 'Which CSS property changes the text colour?', 'options' => ['font-style', 'text-size', 'color', 'background-text'], 'correct' => 2],
                    ['q' => 'Internal CSS is written inside which tag?', 'options' => ['<script>', '<style>', '<css>', '<link>'], 'correct' => 1],
                    ['q' => 'Which tag links an external stylesheet?', 'options' => ['<link rel="stylesheet">', '<style src>', '<css href>', '<import>'], 'correct' => 0],
                    ['q' => 'Which symbol selects an element by its id in CSS?', 'options' => ['.', '*', '&', '#'], 'correct' => 3],
                ],
                'Databases & Forms' => [
                    ['q' => 'Which form method appends submitted data to the URL?', 'options' => ['POST', 'PUT', 'GET', 'SEND'], 'correct' => 2],
                    ['q' => 'Which form attribute defines where the data is sent?', 'options' => ['target-url', 'action', 'method-link', 'name'], 'correct' => 1],
                    ['q' => 'Which SQL command adds a new record to a table?', 'options' => ['INSERT', 'SELECT', 'ALTER', 'TRUNCATE'], 'correct' => 0],
                    ['q' => 'Why is server-side validation necessary even if client-side validation exists?', 'options' => ['Servers are faster than browsers', 'Browsers cannot validate', 'HTML forbids validation', 'Client-side checks can be bypassed'], 'correct' => 3],
                    ['q' => 'Which input type hides the characters being typed?', 'options' => ['hidden', 'secret', 'password', 'text'], 'correct' => 2],
                ],
            ],
            'MS Word Learning' => [
                'Tables & Illustrations' => [
                    ['q' => 'Which tab do you use to insert a table in Word?', 'options' => ['Review', 'Insert', 'View', 'References'], 'correct' => 1],
                    ['q' => 'What does \'Merge Cells\' do in a Word table?', 'options' => ['Combines selected cells into one', 'Splits a table into two', 'Deletes the table', 'Sorts the cells'], 'correct' => 0],
                    ['q' => 'Where do you go to add a picture from your computer?', 'options' => ['Review > Pictures', 'Home > Table', 'View > Zoom', 'Insert > Pictures'], 'correct' => 3],
                    ['q' => 'What is SmartArt used for?', 'options' => ['Spell checking', 'Printing labels', 'Creating visual diagrams such as hierarchies and processes', 'Mail merge'], 'correct' => 2],
                    ['q' => 'Which feature wraps text around a picture?', 'options' => ['Mail Merge', 'Wrap Text', 'Track Changes', 'Word Count'], 'correct' => 1],
                ],
                'Page Layout & Printing' => [
                    ['q' => 'Which orientations can a Word page have?', 'options' => ['Portrait and Landscape', 'Horizontal and Diagonal', 'Tall and Wide only', 'Square and Round'], 'correct' => 0],
                    ['q' => 'Which keyboard shortcut opens the Print screen in Word?', 'options' => ['Ctrl + S', 'Ctrl + O', 'Ctrl + N', 'Ctrl + P'], 'correct' => 3],
                    ['q' => 'What do margins define?', 'options' => ['The font size', 'The paper colour', 'The blank space between the text and the page edge', 'The page number style'], 'correct' => 2],
                    ['q' => 'Headers and footers appear in:', 'options' => ['Only the first line of text', 'The top and bottom margin areas of each page', 'Only inside tables', 'The status bar'], 'correct' => 1],
                    ['q' => 'Which tab contains Margins, Orientation and Size settings?', 'options' => ['Layout (Page Layout)', 'Insert', 'Mailings', 'Review'], 'correct' => 0],
                ],
            ],
            'Photoshop Learning' => [
                'Colors & Adjustments' => [
                    ['q' => 'What does RGB stand for?', 'options' => ['Red, Gray, Black', 'Rose, Gold, Brown', 'Ray, Glow, Blend', 'Red, Green, Blue'], 'correct' => 3],
                    ['q' => 'Which colour mode is best suited for professional printing?', 'options' => ['RGB', 'Grayscale only', 'CMYK', 'Bitmap only'], 'correct' => 2],
                    ['q' => 'Which adjustment changes the overall colour tone of an image?', 'options' => ['Crop', 'Hue/Saturation', 'Move tool', 'Free Transform'], 'correct' => 1],
                    ['q' => 'Where do you find Brightness/Contrast in Photoshop?', 'options' => ['Image > Adjustments', 'File > Open', 'Window > Arrange', 'Edit > Undo'], 'correct' => 0],
                    ['q' => 'The Levels adjustment controls:', 'options' => ['Only font sizes', 'Layer names', 'Canvas rotation', 'Shadows, midtones and highlights'], 'correct' => 3],
                ],
                'Text, Shapes & Filters' => [
                    ['q' => 'What is the keyboard shortcut for the Type tool?', 'options' => ['P', 'M', 'T', 'B'], 'correct' => 2],
                    ['q' => 'Where is Gaussian Blur found?', 'options' => ['Image > Size', 'Filter > Blur', 'Layer > New', 'Select > Inverse'], 'correct' => 1],
                    ['q' => 'What does \'Rasterize Type\' do?', 'options' => ['Converts editable text into pixels', 'Makes the text bold', 'Deletes the text layer', 'Changes the language'], 'correct' => 0],
                    ['q' => 'Which of these is a Shape tool?', 'options' => ['Healing Brush', 'Clone Stamp', 'Eraser', 'Ellipse Tool'], 'correct' => 3],
                    ['q' => 'Smart Filters are useful because they:', 'options' => ['Delete the original image', 'Only work on text', 'Apply filters non-destructively', 'Cannot be edited'], 'correct' => 2],
                ],
            ],
            '1st Year Computer Science' => [
                'Input / Output Devices' => [
                    ['q' => 'Which of these is an input device?', 'options' => ['Monitor', 'Keyboard', 'Printer', 'Speaker'], 'correct' => 1],
                    ['q' => 'Which of these is an output device?', 'options' => ['Monitor', 'Mouse', 'Scanner', 'Microphone'], 'correct' => 0],
                    ['q' => 'A scanner is used to:', 'options' => ['Print documents', 'Play sound', 'Store data permanently', 'Convert printed documents and images into digital form'], 'correct' => 3],
                    ['q' => 'Which device works as both input and output?', 'options' => ['Mouse', 'Printer', 'Touchscreen', 'Speaker'], 'correct' => 2],
                    ['q' => 'Which device produces a hard copy of a document?', 'options' => ['Webcam', 'Printer', 'Joystick', 'Keyboard'], 'correct' => 1],
                ],
            ],
            '2nd Year Computer Science' => [
                'DBMS & MS Access' => [
                    ['q' => 'What is a DBMS?', 'options' => ['Software used to create, store and manage databases', 'A type of keyboard', 'A programming language only', 'An operating system'], 'correct' => 0],
                    ['q' => 'What does a primary key do?', 'options' => ['Sorts the table alphabetically', 'Deletes duplicate tables', 'Encrypts the data', 'Uniquely identifies each record in a table'], 'correct' => 3],
                    ['q' => 'Which MS Access object is used to ask questions of your data?', 'options' => ['Report', 'Macro', 'Query', 'Module'], 'correct' => 2],
                    ['q' => 'Which Access object is mainly used to print formatted data?', 'options' => ['Table', 'Report', 'Form', 'Query'], 'correct' => 1],
                    ['q' => 'What is the default file extension of a modern MS Access database?', 'options' => ['.accdb', '.docx', '.xlsx', '.pptx'], 'correct' => 0],
                ],
                'Functions & Arrays in C' => [
                    ['q' => 'In C, array indexing starts at:', 'options' => ['1', '-1', 'Any number you choose', '0'], 'correct' => 3],
                    ['q' => 'How many elements does \'int arr[5];\' hold?', 'options' => ['4', '6', '5', 'Unlimited'], 'correct' => 2],
                    ['q' => 'Which return type is used when a function returns nothing?', 'options' => ['null', 'void', 'int', 'empty'], 'correct' => 1],
                    ['q' => 'A function prototype is:', 'options' => ['A declaration telling the compiler the function\'s name, return type and parameters', 'A loop', 'A header file', 'A comment'], 'correct' => 0],
                    ['q' => 'Array elements in C are stored in:', 'options' => ['Random memory locations', 'Only the hard disk', 'A linked list automatically', 'Contiguous memory locations'], 'correct' => 3],
                ],
            ],
            '1st Year Islamiat' => [
                'Islamic Society & Ethics' => [
                    ['q' => 'Which principle does Islam place at the heart of a just society?', 'options' => ['Wealth only', 'Social class', 'Justice (\'Adl)', 'Tribal loyalty'], 'correct' => 2],
                    ['q' => 'The bond of brotherhood (Mu\'akhat) was established by the Prophet (SAW) between:', 'options' => ['Quraish and Byzantines', 'The Muhajirin and the Ansar', 'Traders and farmers only', 'Two tribes at war'], 'correct' => 1],
                    ['q' => 'Which moral quality is called \'Sidq\' in Islam?', 'options' => ['Truthfulness', 'Generosity', 'Patience', 'Humility'], 'correct' => 0],
                    ['q' => 'According to Islamic teachings, how should neighbours be treated?', 'options' => ['With indifference', 'Only if they are relatives', 'With suspicion', 'With kindness and respect'], 'correct' => 3],
                    ['q' => 'Which of the following is a major sin in Islamic ethics?', 'options' => ['Helping the poor', 'Honesty in trade', 'Backbiting (Gheebat)', 'Keeping promises'], 'correct' => 2],
                ],
            ],
            '1st Year Mathematics' => [
                'Sequences & Series' => [
                    ['q' => 'What is the common difference of the AP 2, 5, 8, 11, ...?', 'options' => ['2', '3', '5', '4'], 'correct' => 1],
                    ['q' => 'The nth term of an Arithmetic Progression is:', 'options' => ['a + (n - 1)d', 'a r^(n-1)', 'n(n + 1)/2', 'a + nd^2'], 'correct' => 0],
                    ['q' => 'What is the common ratio of the GP 2, 4, 8, 16, ...?', 'options' => ['4', '8', '1/2', '2'], 'correct' => 3],
                    ['q' => 'The sum of the first n natural numbers is:', 'options' => ['n(n - 1)', 'n^2 + 1', 'n(n + 1)/2', '2n'], 'correct' => 2],
                    ['q' => 'What is the 10th term of the AP 3, 7, 11, ...?', 'options' => ['40', '39', '43', '37'], 'correct' => 1],
                ],
            ],
            '2nd Year Chemistry' => [
                'Transition Elements' => [
                    ['q' => 'Transition elements belong to which block of the periodic table?', 'options' => ['d-block', 's-block', 'p-block', 'f-block only'], 'correct' => 0],
                    ['q' => 'Which property is characteristic of transition elements?', 'options' => ['Always one oxidation state', 'Being gases at room temperature', 'Being non-metals', 'Variable oxidation states'], 'correct' => 3],
                    ['q' => 'Why are many transition metal compounds coloured?', 'options' => ['Because of nuclear reactions', 'Because they are radioactive', 'Because of d-d electronic transitions', 'Because they contain water only'], 'correct' => 2],
                    ['q' => 'Which of these is a transition element?', 'options' => ['Sodium', 'Iron', 'Chlorine', 'Helium'], 'correct' => 1],
                    ['q' => 'Which transition metal is used as a catalyst in the Haber process?', 'options' => ['Iron', 'Gold', 'Zinc chloride', 'Calcium'], 'correct' => 0],
                ],
                'Alcohols, Phenols & Ethers' => [
                    ['q' => 'What is the functional group of alcohols?', 'options' => ['-COOH', '-CHO', '-NH2', '-OH'], 'correct' => 3],
                    ['q' => 'What is the molecular formula of ethanol?', 'options' => ['CH3OH', 'C3H7OH', 'C2H5OH', 'CH3COOH'], 'correct' => 2],
                    ['q' => 'In phenol, the -OH group is attached to:', 'options' => ['A straight chain only', 'A benzene ring', 'A nitrogen atom', 'A carbonyl carbon'], 'correct' => 1],
                    ['q' => 'What is the general formula of ethers?', 'options' => ['R-O-R\'', 'R-OH', 'R-COOH', 'R-CHO'], 'correct' => 0],
                    ['q' => 'Methanol is commonly known as:', 'options' => ['Grain alcohol', 'Rubbing alcohol only', 'Vinegar', 'Wood spirit'], 'correct' => 3],
                ],
                'Environmental Chemistry' => [
                    ['q' => 'In which layer of the atmosphere is the ozone layer found?', 'options' => ['Troposphere', 'Mesosphere', 'Stratosphere', 'Exosphere'], 'correct' => 2],
                    ['q' => 'Which chemicals are mainly responsible for ozone depletion?', 'options' => ['Oxygen', 'Chlorofluorocarbons (CFCs)', 'Nitrogen', 'Argon'], 'correct' => 1],
                    ['q' => 'Acid rain typically has a pH lower than:', 'options' => ['5.6', '7', '8.5', '10'], 'correct' => 0],
                    ['q' => 'Which gas is the main contributor to the greenhouse effect?', 'options' => ['Argon', 'Helium', 'Neon', 'Carbon dioxide'], 'correct' => 3],
                    ['q' => 'Which pollutant is a main cause of acid rain?', 'options' => ['Oxygen', 'Hydrogen', 'Sulphur dioxide', 'Neon'], 'correct' => 2],
                ],
            ],
            '2nd Year English' => [
                'Translation & Composition' => [
                    ['q' => 'Translation means:', 'options' => ['Copying a text word for word in the same language', 'Expressing the meaning of a text in another language', 'Summarising a text in the same words', 'Reading aloud'], 'correct' => 1],
                    ['q' => 'The sentence that states the main idea of a paragraph is the:', 'options' => ['Topic sentence', 'Concluding sentence', 'Title', 'Footnote'], 'correct' => 0],
                    ['q' => 'Which are the three main parts of an essay?', 'options' => ['Title, author and date', 'Question, answer and note', 'Header, footer and margin', 'Introduction, body and conclusion'], 'correct' => 3],
                    ['q' => 'Which salutation is suitable for a formal application?', 'options' => ['Hi buddy', 'Hey there', 'Respected Sir', 'Dear friend'], 'correct' => 2],
                    ['q' => 'Which is an important quality of good composition?', 'options' => ['Using very long sentences always', 'Clarity and unity of ideas', 'Repeating the same point', 'Ignoring grammar'], 'correct' => 1],
                ],
                'Book II & Plays' => [
                    ['q' => 'A play is primarily written to be:', 'options' => ['Performed on stage', 'Sung as a song', 'Studied as a map', 'Printed as a newspaper'], 'correct' => 0],
                    ['q' => 'Who wrote the tragedy \'Macbeth\'?', 'options' => ['Charles Dickens', 'John Keats', 'George Orwell', 'William Shakespeare'], 'correct' => 3],
                    ['q' => 'The conversation between characters in a play is called:', 'options' => ['Monologue', 'Prologue', 'Dialogue', 'Epilogue'], 'correct' => 2],
                    ['q' => 'A play is usually divided into:', 'options' => ['Stanzas and verses', 'Acts and scenes', 'Chapters and sections', 'Paragraphs only'], 'correct' => 1],
                    ['q' => 'Which of these is a type of drama?', 'options' => ['Comedy', 'Haiku', 'Sonnet', 'Editorial'], 'correct' => 0],
                ],
                'Comprehension' => [
                    ['q' => 'The main idea of a passage is:', 'options' => ['The first word', 'The longest sentence', 'The last punctuation mark', 'The central point the writer wants to communicate'], 'correct' => 3],
                    ['q' => 'Making an \'inference\' means:', 'options' => ['Copying a sentence exactly', 'Counting the words', 'Drawing a conclusion from clues in the text', 'Ignoring the passage'], 'correct' => 2],
                    ['q' => 'What does \'skimming\' mean?', 'options' => ['Reading every word slowly', 'Reading quickly to get the general idea', 'Reading only the last line', 'Memorising the passage'], 'correct' => 1],
                    ['q' => 'The best title for a passage should:', 'options' => ['Reflect its central theme', 'Be unrelated to it', 'Be the longest possible', 'Contain only numbers'], 'correct' => 0],
                    ['q' => 'To find the meaning of an unknown word, a reader can use:', 'options' => ['Random guessing only', 'Skipping the whole passage', 'The page number', 'Context clues'], 'correct' => 3],
                ],
            ],
            '2nd Year Pak Study (Urdu)' => [
                'Economy & Resources' => [
                    ['q' => 'پاکستان کی معیشت میں ریڑھ کی ہڈی کس شعبے کو کہا جاتا ہے؟', 'options' => ['سیاحت', 'کھیل', 'زراعت', 'فلم سازی'], 'correct' => 2],
                    ['q' => 'پاکستان کی اہم نقد فصل (کیش کراپ) کون سی ہے؟', 'options' => ['مکئی', 'کپاس', 'جو', 'باجرہ'], 'correct' => 1],
                    ['q' => 'گندم کس موسم کی فصل ہے؟', 'options' => ['ربیع', 'خریف', 'برسات میں صرف', 'بارہ ماہی'], 'correct' => 0],
                    ['q' => 'پاکستان کا مرکزی بینک کون سا ہے؟', 'options' => ['حبیب بینک', 'نیشنل بینک', 'یونائیٹڈ بینک', 'اسٹیٹ بینک آف پاکستان'], 'correct' => 3],
                    ['q' => 'پاکستان کی قومی کرنسی کیا ہے؟', 'options' => ['ڈالر', 'ریال', 'روپیہ', 'درہم'], 'correct' => 2],
                ],
                'Foreign Policy' => [
                    ['q' => 'پاکستان اقوامِ متحدہ کا رکن کب بنا؟', 'options' => ['14 اگست 1947ء', '30 ستمبر 1947ء', '23 مارچ 1940ء', '1 جنوری 1950ء'], 'correct' => 1],
                    ['q' => 'پاکستان کی خارجہ پالیسی کا بنیادی مقصد کیا ہے؟', 'options' => ['قومی سلامتی اور علاقائی سالمیت کا تحفظ', 'صرف تجارت', 'صرف کھیلوں کا فروغ', 'کسی سے تعلق نہ رکھنا'], 'correct' => 0],
                    ['q' => 'مسئلہ کشمیر پر پاکستان کا تنازع کس ملک سے ہے؟', 'options' => ['چین', 'ایران', 'افغانستان', 'بھارت'], 'correct' => 3],
                    ['q' => 'سی پیک (CPEC) پاکستان کو کس ملک سے جوڑتا ہے؟', 'options' => ['روس', 'جاپان', 'چین', 'برازیل'], 'correct' => 2],
                    ['q' => 'اسلامی تعاون تنظیم (OIC) کا قیام کس سال عمل میں آیا؟', 'options' => ['1947ء', '1969ء', '1985ء', '2001ء'], 'correct' => 1],
                ],
            ],
            '1st Year Sociology (Eng)' => [
                'Introduction to Sociology' => [
                    ['q' => 'Who introduced the term \'sociology\' in 1838?', 'options' => ['Auguste Comte', 'Karl Marx', 'Max Weber', 'Herbert Spencer'], 'correct' => 0],
                    ['q' => 'The word \'sociology\' comes from which two roots?', 'options' => ['Greek \'bios\' and \'logos\'', 'Latin \'homo\' and \'polis\'', 'Arabic \'ilm\' and \'sharq\'', 'Latin \'socius\' and Greek \'logos\''], 'correct' => 3],
                    ['q' => 'Who wrote \'The Division of Labour in Society\'?', 'options' => ['Auguste Comte', 'Ibn Khaldun', 'Emile Durkheim', 'Charles Cooley'], 'correct' => 2],
                    ['q' => 'Which Muslim thinker is regarded as a pioneer of social science through his \'Muqaddimah\'?', 'options' => ['Al-Ghazali', 'Ibn Khaldun', 'Ibn Sina', 'Al-Farabi'], 'correct' => 1],
                    ['q' => 'Sociology is classified as a:', 'options' => ['Social science', 'Natural science', 'Physical science', 'Applied mathematics'], 'correct' => 0],
                ],
                'Society & Community' => [
                    ['q' => 'Society is best defined as:', 'options' => ['A group of buildings', 'A collection of animals', 'An economic market only', 'A web of social relationships'], 'correct' => 3],
                    ['q' => 'Which scholars described society as \'a web of social relationships\'?', 'options' => ['Marx and Engels', 'Comte and Spencer', 'MacIver and Page', 'Weber and Durkheim'], 'correct' => 2],
                    ['q' => 'A community is a group of people who:', 'options' => ['Meet only once a year', 'Live in a particular area and share a common way of life', 'Never interact with each other', 'Belong to different countries'], 'correct' => 1],
                    ['q' => 'Who introduced the concepts of Gemeinschaft and Gesellschaft?', 'options' => ['Ferdinand Tonnies', 'Karl Marx', 'Auguste Comte', 'William Ogburn'], 'correct' => 0],
                    ['q' => 'Which is a typical characteristic of a rural community?', 'options' => ['Anonymity among neighbours', 'Highly formal contracts', 'Heavy traffic', 'Close, personal relationships'], 'correct' => 3],
                    ['q' => 'Which is a characteristic of an urban community?', 'options' => ['Everyone knowing everyone', 'Complete dependence on farming', 'Heterogeneity and impersonal relationships', 'Absence of occupations'], 'correct' => 2],
                    ['q' => 'Which element is essential for the existence of society?', 'options' => ['Large buildings', 'Social relationships among people', 'A written constitution only', 'Technology only'], 'correct' => 1],
                ],
                'Culture' => [
                    ['q' => 'Culture is best described as:', 'options' => ['The total way of life of a society', 'Only art and music', 'Only language', 'Only clothing'], 'correct' => 0],
                    ['q' => 'Who defined culture as \'that complex whole including knowledge, belief, art, morals, law and custom\'?', 'options' => ['Emile Durkheim', 'Max Weber', 'George Mead', 'Edward B. Tylor'], 'correct' => 3],
                    ['q' => 'Which of the following is an example of material culture?', 'options' => ['Beliefs', 'Values', 'Tools and buildings', 'Customs'], 'correct' => 2],
                    ['q' => 'The term \'cultural lag\' was introduced by:', 'options' => ['Auguste Comte', 'William Ogburn', 'Charles Cooley', 'Robert Merton'], 'correct' => 1],
                    ['q' => 'Judging another culture by the standards of one\'s own culture is called:', 'options' => ['Ethnocentrism', 'Cultural relativism', 'Socialization', 'Diffusion'], 'correct' => 0],
                    ['q' => 'A subculture is:', 'options' => ['A culture with no values', 'A foreign culture', 'A dead culture', 'A smaller culture within a larger culture'], 'correct' => 3],
                ],
                'Socialization' => [
                    ['q' => 'The process by which individuals learn the norms and values of their society is called:', 'options' => ['Urbanisation', 'Industrialisation', 'Socialization', 'Migration'], 'correct' => 2],
                    ['q' => 'Who developed the concept of the \'looking-glass self\'?', 'options' => ['Karl Marx', 'Charles Horton Cooley', 'Emile Durkheim', 'Auguste Comte'], 'correct' => 1],
                    ['q' => 'The concepts of \'I\' and \'Me\' are associated with:', 'options' => ['George Herbert Mead', 'Max Weber', 'Ibn Khaldun', 'Herbert Spencer'], 'correct' => 0],
                    ['q' => 'Which of the following is an agent of socialization?', 'options' => ['Weather', 'Volcano', 'Ocean', 'Peer group'], 'correct' => 3],
                    ['q' => 'Which agent is most influential during early childhood?', 'options' => ['Mass media', 'Workplace', 'Family', 'Political party'], 'correct' => 2],
                    ['q' => 'Cases of children raised in extreme isolation show that:', 'options' => ['Humans learn language without contact', 'Social interaction is essential for human development', 'Socialization is unnecessary', 'Genes alone decide behaviour'], 'correct' => 1],
                ],
                'Social Groups & Institutions' => [
                    ['q' => 'The term \'primary group\' was introduced by:', 'options' => ['Charles Horton Cooley', 'Max Weber', 'Karl Marx', 'Herbert Spencer'], 'correct' => 0],
                    ['q' => 'Which pair of terms was introduced by William Graham Sumner?', 'options' => ['Nuclear and joint', 'Rural and urban', 'Sacred and profane', 'In-group and out-group'], 'correct' => 3],
                    ['q' => 'Which of the following is an example of a secondary group?', 'options' => ['A family', 'A close friend circle', 'A trade union', 'A childhood playgroup'], 'correct' => 2],
                    ['q' => 'A social institution is:', 'options' => ['A single building', 'An established system of norms that meets basic social needs', 'A temporary gathering', 'A private hobby'], 'correct' => 1],
                    ['q' => 'Which institution regulates power, law and order in society?', 'options' => ['Political institution', 'Family', 'Religion', 'Recreation'], 'correct' => 0],
                    ['q' => 'Which is the most universal social institution?', 'options' => ['Stock market', 'Sports club', 'Political party', 'Family'], 'correct' => 3],
                ],
                'Social Change' => [
                    ['q' => 'Social change refers to:', 'options' => ['Staying exactly the same', 'A change in weather', 'Alteration in social structure and relationships over time', 'A change in a person\'s clothes only'], 'correct' => 2],
                    ['q' => 'Which type of change is slow and gradual?', 'options' => ['Revolution', 'Evolution', 'Coup', 'Riot'], 'correct' => 1],
                    ['q' => 'A rapid and fundamental change in society is called:', 'options' => ['Revolution', 'Evolution', 'Stagnation', 'Tradition'], 'correct' => 0],
                    ['q' => 'Which of the following is a major factor of social change?', 'options' => ['Fixed customs', 'Isolation only', 'Silence', 'Technology'], 'correct' => 3],
                    ['q' => 'The spread of cultural traits from one society to another is called:', 'options' => ['Cultural lag', 'Ethnocentrism', 'Cultural diffusion', 'Endogamy'], 'correct' => 2],
                    ['q' => 'A social movement is:', 'options' => ['A private journey', 'An organised collective effort to bring about or resist change', 'A holiday', 'A family meal'], 'correct' => 1],
                    ['q' => 'Industrialisation commonly leads to:', 'options' => ['Urbanisation and changes in family structure', 'Complete rural isolation', 'No change in occupations', 'Reduced use of machines'], 'correct' => 0],
                ],
            ],
            '2nd Year Education (Eng)' => [
                'Concept of Education' => [
                    ['q' => 'Education that takes place in schools with a planned curriculum and certificates is called:', 'options' => ['Informal education', 'Incidental learning', 'Peer chat', 'Formal education'], 'correct' => 3],
                    ['q' => 'Learning that happens through daily life, family and society without a fixed syllabus is:', 'options' => ['Formal education', 'University education', 'Informal education', 'Technical education'], 'correct' => 2],
                    ['q' => 'Adult literacy programmes run outside the regular school system are examples of:', 'options' => ['Formal education', 'Non-formal education', 'Pre-school education', 'Higher education'], 'correct' => 1],
                    ['q' => 'Education is best described as a:', 'options' => ['Lifelong process', 'One-day event', 'Process that ends at age 10', 'Process that ends after matric'], 'correct' => 0],
                    ['q' => 'Who described education as the \'natural, harmonious and progressive development of man\'s innate powers\'?', 'options' => ['Pavlov', 'Skinner', 'Bloom', 'Pestalozzi'], 'correct' => 3],
                    ['q' => 'Which is a basic function of education?', 'options' => ['Increasing prices', 'Reducing the population', 'Transmitting culture and knowledge to the next generation', 'Preventing change'], 'correct' => 2],
                ],
                'Aims & Objectives of Education' => [
                    ['q' => 'The aims of education:', 'options' => ['Have no value', 'Give direction to the educational process', 'Are decided only by students', 'Change every minute'], 'correct' => 1],
                    ['q' => 'How do aims differ from objectives?', 'options' => ['Aims are broad and long-term; objectives are specific and short-term', 'Aims are specific; objectives are broad', 'They are exactly the same', 'Aims apply only to teachers'], 'correct' => 0],
                    ['q' => 'Who proposed the famous taxonomy of educational objectives?', 'options' => ['Jean Piaget', 'Ivan Pavlov', 'John Dewey', 'Benjamin Bloom'], 'correct' => 3],
                    ['q' => 'Which are the three domains of Bloom\'s taxonomy?', 'options' => ['Physical, chemical and biological', 'Social, political and economic', 'Cognitive, affective and psychomotor', 'Visual, aural and verbal'], 'correct' => 2],
                    ['q' => 'Which domain deals with attitudes, interests and values?', 'options' => ['Cognitive domain', 'Affective domain', 'Psychomotor domain', 'Physical domain'], 'correct' => 1],
                    ['q' => 'Which domain mainly concerns physical skills and coordination?', 'options' => ['Psychomotor domain', 'Affective domain', 'Cognitive domain', 'Moral domain'], 'correct' => 0],
                    ['q' => 'The vocational aim of education focuses on:', 'options' => ['Only memorising poems', 'Entertainment', 'Avoiding work', 'Preparing individuals for a livelihood'], 'correct' => 3],
                ],
                'Curriculum & Teaching Methods' => [
                    ['q' => 'Which method of teaching is mostly teacher-centred?', 'options' => ['Project method', 'Activity method', 'Lecture method', 'Discovery method'], 'correct' => 2],
                    ['q' => 'The project method of teaching is associated with:', 'options' => ['Ivan Pavlov', 'William Kilpatrick', 'Max Weber', 'Auguste Comte'], 'correct' => 1],
                    ['q' => 'A lesson plan is:', 'options' => ['A teacher\'s organised outline of what and how to teach', 'A student\'s timetable', 'An exam paper', 'A school building map'], 'correct' => 0],
                    ['q' => 'The \'hidden curriculum\' refers to:', 'options' => ['The official textbook', 'The exam syllabus', 'Secret exam questions', 'Unwritten lessons and values students learn at school'], 'correct' => 3],
                    ['q' => 'Which approach places the learner at the centre of the learning process?', 'options' => ['Pure lecturing', 'Rote copying only', 'Activity-based learning', 'Silent reading only'], 'correct' => 2],
                    ['q' => 'Audio-visual aids help teaching mainly by:', 'options' => ['Making lessons longer', 'Making concepts clearer and more interesting', 'Replacing the teacher completely', 'Removing the need for students'], 'correct' => 1],
                    ['q' => 'Which of these is an element of a curriculum?', 'options' => ['Objectives, content, methods and evaluation', 'Only chairs and desks', 'Only a bell', 'Only school fees'], 'correct' => 0],
                ],
                'Educational Psychology' => [
                    ['q' => 'Educational psychology is the study of:', 'options' => ['Rocks and minerals', 'Planetary motion', 'Stock markets', 'Learning and teaching behaviour'], 'correct' => 3],
                    ['q' => 'Classical conditioning is associated with:', 'options' => ['B. F. Skinner', 'Jean Piaget', 'Ivan Pavlov', 'Abraham Maslow'], 'correct' => 2],
                    ['q' => 'Operant conditioning is associated with:', 'options' => ['Ivan Pavlov', 'B. F. Skinner', 'Sigmund Freud', 'Benjamin Bloom'], 'correct' => 1],
                    ['q' => 'Which psychologist proposed stages of cognitive development?', 'options' => ['Jean Piaget', 'Ivan Pavlov', 'Edward Thorndike', 'Max Weber'], 'correct' => 0],
                    ['q' => 'What is the first stage in Piaget\'s theory?', 'options' => ['Formal operational stage', 'Concrete operational stage', 'Pre-operational stage', 'Sensorimotor stage'], 'correct' => 3],
                    ['q' => 'Thorndike\'s \'Law of Effect\' states that:', 'options' => ['Learning never changes behaviour', 'Practice has no effect', 'Behaviour followed by satisfaction is likely to be repeated', 'Rewards reduce learning'], 'correct' => 2],
                    ['q' => 'Who proposed the \'hierarchy of needs\'?', 'options' => ['Jean Piaget', 'Abraham Maslow', 'Ivan Pavlov', 'John Locke'], 'correct' => 1],
                    ['q' => 'Motivation in learning means:', 'options' => ['An inner drive that pushes a learner towards a goal', 'A school holiday', 'A type of exam', 'A teaching aid'], 'correct' => 0],
                ],
                'Education System in Pakistan' => [
                    ['q' => 'Primary education in Pakistan normally covers which classes?', 'options' => ['Class 6 to 8', 'Class 9 to 10', 'Class 11 to 12', 'Class 1 to 5'], 'correct' => 3],
                    ['q' => 'Secondary school (Matric) in Pakistan covers which classes?', 'options' => ['Class 1 and 2', 'Class 11 and 12', 'Class 9 and 10', 'Class 14 and 16'], 'correct' => 2],
                    ['q' => 'The Higher Education Commission (HEC) of Pakistan was established in:', 'options' => ['1947', '2002', '1973', '2018'], 'correct' => 1],
                    ['q' => 'Article 25-A of Pakistan\'s Constitution guarantees:', 'options' => ['Free and compulsory education for children aged 5 to 16', 'Free housing', 'Free transport for all', 'Free medical degrees only'], 'correct' => 0],
                    ['q' => 'Who conducts Matric and Intermediate examinations in Pakistan?', 'options' => ['Pakistan Railways', 'State Bank of Pakistan', 'Election Commission', 'Boards of Intermediate and Secondary Education'], 'correct' => 3],
                    ['q' => 'Which university in Pakistan is known for distance learning?', 'options' => ['Lahore Zoo', 'Karachi Port', 'Allama Iqbal Open University', 'Wapda'], 'correct' => 2],
                    ['q' => 'Madrassah education mainly focuses on:', 'options' => ['Only aviation', 'Religious education alongside other subjects', 'Only sports', 'Only cooking'], 'correct' => 1],
                ],
            ],
            '2nd Year Sociology (Eng)' => [
                'Social Institutions' => [
                    ['q' => 'Which of the following lists the five basic social institutions?', 'options' => ['Family, religion, education, economy and polity', 'Cinema, sports, music, fashion and art', 'Bank, shop, factory, farm and mall', 'School, park, road, market and hospital'], 'correct' => 0],
                    ['q' => 'The main function of the educational institution is to:', 'options' => ['Collect taxes', 'Make laws', 'Regulate marriage only', 'Transmit knowledge, skills and values'], 'correct' => 3],
                    ['q' => 'The economic institution is concerned with:', 'options' => ['Worship', 'Raising children only', 'Production, distribution and consumption of goods and services', 'Entertainment only'], 'correct' => 2],
                    ['q' => 'The political institution deals mainly with:', 'options' => ['Farming', 'Power, authority and governance', 'Cooking', 'Fashion'], 'correct' => 1],
                    ['q' => 'Which sociologist distinguished between manifest and latent functions?', 'options' => ['Robert K. Merton', 'Auguste Comte', 'Ibn Khaldun', 'Charles Cooley'], 'correct' => 0],
                    ['q' => 'Social institutions are important because they:', 'options' => ['Cause chaos', 'Remove all rules', 'Prevent cooperation', 'Organise behaviour to meet society\'s basic needs'], 'correct' => 3],
                ],
                'Family & Marriage' => [
                    ['q' => 'A family that includes parents, children and other relatives living together is a:', 'options' => ['Nuclear family', 'Single-parent family only', 'Joint (extended) family', 'Corporate family'], 'correct' => 2],
                    ['q' => 'Marriage of one man to more than one woman is called:', 'options' => ['Monogamy', 'Polygyny', 'Polyandry', 'Endogamy'], 'correct' => 1],
                    ['q' => 'Marriage within one\'s own group, caste or community is called:', 'options' => ['Endogamy', 'Exogamy', 'Monogamy', 'Polygyny'], 'correct' => 0],
                    ['q' => 'Marriage outside one\'s own group is called:', 'options' => ['Endogamy', 'Monogamy', 'Polyandry', 'Exogamy'], 'correct' => 3],
                    ['q' => 'In a patriarchal family, authority rests mainly with:', 'options' => ['The eldest female', 'The youngest child', 'The eldest male', 'The neighbours'], 'correct' => 2],
                ],
                'Religion & Society' => [
                    ['q' => 'Durkheim divided religious things into:', 'options' => ['Good and bad', 'Sacred and profane', 'Rich and poor', 'Old and new'], 'correct' => 1],
                    ['q' => 'Who wrote \'The Protestant Ethic and the Spirit of Capitalism\'?', 'options' => ['Max Weber', 'Karl Marx', 'Auguste Comte', 'Emile Durkheim'], 'correct' => 0],
                    ['q' => 'Who called religion \'the opium of the people\'?', 'options' => ['Max Weber', 'Charles Cooley', 'Ibn Khaldun', 'Karl Marx'], 'correct' => 3],
                    ['q' => 'Which is a social function of religion?', 'options' => ['Eliminating all norms', 'Creating inequality only', 'Promoting social cohesion and shared values', 'Stopping communication'], 'correct' => 2],
                    ['q' => 'Secularisation refers to:', 'options' => ['The growth of religion everywhere', 'The declining influence of religion in public life', 'A type of worship', 'A holy book'], 'correct' => 1],
                    ['q' => 'Monotheism means belief in:', 'options' => ['One God', 'Many gods', 'No god', 'Nature spirits only'], 'correct' => 0],
                    ['q' => 'Sociologists study religion mainly as:', 'options' => ['A personal secret only', 'A kind of science experiment', 'An economic product', 'A social institution'], 'correct' => 3],
                ],
                'Social Problems' => [
                    ['q' => 'Poverty is a condition in which people:', 'options' => ['Have too many resources', 'Do not need food', 'Lack resources to meet basic needs', 'Have high incomes'], 'correct' => 2],
                    ['q' => 'Juvenile delinquency refers to:', 'options' => ['Obedience by children', 'Law-breaking behaviour by young people', 'School attendance', 'Sports activity'], 'correct' => 1],
                    ['q' => 'Which of the following is a social problem?', 'options' => ['Drug addiction', 'Seasonal rainfall', 'Sunrise', 'Tides'], 'correct' => 0],
                    ['q' => 'Corruption means:', 'options' => ['Honest service', 'Paying taxes', 'Voting', 'Misuse of public office for private gain'], 'correct' => 3],
                    ['q' => 'Unemployment occurs when:', 'options' => ['Everyone has a job', 'People refuse to leave home', 'People who are able and willing to work cannot find jobs', 'Schools close for holidays'], 'correct' => 2],
                    ['q' => 'A major cause of social problems such as crime is often:', 'options' => ['Good education for all', 'Poverty and lack of opportunity', 'Stable jobs', 'Strong community support'], 'correct' => 1],
                ],
                'Population & Urbanisation' => [
                    ['q' => 'Demography is the study of:', 'options' => ['Human populations', 'Rocks', 'Stars', 'Machines'], 'correct' => 0],
                    ['q' => 'Who argued that population grows geometrically while food supply grows arithmetically?', 'options' => ['Karl Marx', 'Max Weber', 'Emile Durkheim', 'Thomas Malthus'], 'correct' => 3],
                    ['q' => 'The crude birth rate is the number of births per:', 'options' => ['100 people per month', '10 people per day', '1000 people per year', '1 million people per decade'], 'correct' => 2],
                    ['q' => 'Urbanisation means:', 'options' => ['Moving from cities to villages', 'The growth of the proportion of people living in cities', 'Declining city populations', 'Farming expansion'], 'correct' => 1],
                    ['q' => 'Moving from one place to another to settle is called:', 'options' => ['Migration', 'Mortality', 'Fertility', 'Literacy'], 'correct' => 0],
                    ['q' => 'Which is a common problem caused by rapid urbanisation?', 'options' => ['Too much open land', 'Fewer vehicles', 'Lower demand for housing', 'Overcrowding and slums'], 'correct' => 3],
                ],
                'Research Methods' => [
                    ['q' => 'A hypothesis is:', 'options' => ['A final proven law', 'A newspaper article', 'A testable statement about the relationship between variables', 'A random guess with no purpose'], 'correct' => 2],
                    ['q' => 'A questionnaire is:', 'options' => ['A type of map', 'A set of written questions used to collect data', 'A statistical formula', 'A research budget'], 'correct' => 1],
                    ['q' => 'In participant observation, the researcher:', 'options' => ['Joins the group being studied', 'Never meets the group', 'Only reads old books', 'Uses only computers'], 'correct' => 0],
                    ['q' => 'A sample is:', 'options' => ['The entire population', 'A research title', 'A final report', 'A smaller group selected from the whole population'], 'correct' => 3],
                    ['q' => 'Which method collects data by asking questions face to face?', 'options' => ['Experiment on plants', 'Telescope survey', 'Interview', 'Chemical analysis'], 'correct' => 2],
                    ['q' => 'A case study involves:', 'options' => ['Surveying millions of people quickly', 'In-depth study of a single person, group or event', 'Counting stars', 'Measuring rainfall'], 'correct' => 1],
                    ['q' => 'Which of the following is a quantitative research tool?', 'options' => ['Survey with numerical data', 'Open diary reflection only', 'Poem analysis', 'Informal chat only'], 'correct' => 0],
                ],
            ],
            '1st Year Sociology (Urdu)' => [
                'Introduction to Sociology' => [
                    ['q' => 'آگسٹ کومٹے نے لفظ \'عمرانیات\' (Sociology) کب متعارف کرایا؟', 'options' => ['1700ء', '1900ء', '1947ء', '1838ء'], 'correct' => 3],
                    ['q' => 'لفظ Sociology کن دو زبانوں کے الفاظ سے مل کر بنا ہے؟', 'options' => ['عربی اور فارسی', 'انگریزی اور جرمن', 'لاطینی \'Socius\' اور یونانی \'Logos\'', 'سنسکرت اور اردو'], 'correct' => 2],
                    ['q' => '\'سماج میں تقسیمِ محنت\' (Division of Labour in Society) کس کی تصنیف ہے؟', 'options' => ['آگسٹ کومٹے', 'ایمائل ڈرکھائم', 'ابنِ خلدون', 'چارلس کولے'], 'correct' => 1],
                    ['q' => '\'مقدمہ\' کے مصنف کو کس شعبے کا ابتدائی ماہر مانا جاتا ہے؟', 'options' => ['عمرانیات (سماجی علوم)', 'علمِ فلکیات', 'علمِ نباتات', 'علمِ کیمیا'], 'correct' => 0],
                    ['q' => 'عمرانیات کس قسم کا علم ہے؟', 'options' => ['طبعی سائنس', 'خالص ریاضی', 'حیاتیاتی سائنس', 'سماجی سائنس'], 'correct' => 3],
                ],
                'Society & Community' => [
                    ['q' => 'معاشرے کی بہترین تعریف کون سی ہے؟', 'options' => ['عمارتوں کا مجموعہ', 'جانوروں کا گروہ', 'سماجی تعلقات کا جال', 'صرف منڈی'], 'correct' => 2],
                    ['q' => 'معاشرے کو \'سماجی تعلقات کا جال\' کس نے کہا؟', 'options' => ['مارکس اور اینگلز', 'میکائیور اور پیج', 'کومٹے اور اسپنسر', 'ویبر اور ڈرکھائم'], 'correct' => 1],
                    ['q' => 'برادری (Community) سے مراد ایسے لوگ ہیں جو:', 'options' => ['ایک مخصوص علاقے میں رہتے ہوں اور مشترکہ طرزِ زندگی رکھتے ہوں', 'سال میں ایک بار ملتے ہوں', 'آپس میں کوئی تعلق نہ رکھتے ہوں', 'مختلف ممالک سے ہوں'], 'correct' => 0],
                    ['q' => '\'Gemeinschaft\' اور \'Gesellschaft\' کے تصورات کس نے پیش کیے؟', 'options' => ['کارل مارکس', 'آگسٹ کومٹے', 'ولیم اوگبرن', 'فرڈینینڈ ٹونیز'], 'correct' => 3],
                    ['q' => 'دیہی برادری کی نمایاں خصوصیت کیا ہے؟', 'options' => ['ہمسایوں میں گمنامی', 'صرف رسمی معاہدے', 'قریبی اور ذاتی تعلقات', 'بھاری ٹریفک'], 'correct' => 2],
                    ['q' => 'شہری برادری کی نمایاں خصوصیت کون سی ہے؟', 'options' => ['ہر شخص کا ہر دوسرے کو جاننا', 'تنوع اور غیر ذاتی تعلقات', 'صرف زراعت پر انحصار', 'پیشوں کا نہ ہونا'], 'correct' => 1],
                    ['q' => 'معاشرے کے وجود کے لیے سب سے ضروری عنصر کیا ہے؟', 'options' => ['افراد کے درمیان سماجی تعلقات', 'بلند عمارتیں', 'صرف تحریری آئین', 'صرف ٹیکنالوجی'], 'correct' => 0],
                ],
                'Culture' => [
                    ['q' => 'ثقافت کی بہترین تعریف کون سی ہے؟', 'options' => ['صرف فنونِ لطیفہ', 'صرف زبان', 'صرف لباس', 'کسی معاشرے کا مکمل طرزِ زندگی'], 'correct' => 3],
                    ['q' => 'ثقافت کو \'علم، عقائد، فن، اخلاق، قانون اور رسوم کا پیچیدہ مجموعہ\' کس نے کہا؟', 'options' => ['ایمائل ڈرکھائم', 'میکس ویبر', 'ایڈورڈ ٹائلر', 'جارج میڈ'], 'correct' => 2],
                    ['q' => 'مادی ثقافت کی مثال کون سی ہے؟', 'options' => ['عقائد', 'اوزار اور عمارتیں', 'اقدار', 'رسوم و رواج'], 'correct' => 1],
                    ['q' => '\'ثقافتی تاخیر\' (Cultural Lag) کی اصطلاح کس نے متعارف کرائی؟', 'options' => ['ولیم اوگبرن', 'آگسٹ کومٹے', 'چارلس کولے', 'رابرٹ مرٹن'], 'correct' => 0],
                    ['q' => 'اپنی ثقافت کے معیار پر دوسری ثقافتوں کو پرکھنا کیا کہلاتا ہے؟', 'options' => ['ثقافتی اضافیت', 'سماج کاری', 'ثقافتی پھیلاؤ', 'نسلی/ثقافتی تعصب (Ethnocentrism)'], 'correct' => 3],
                    ['q' => 'ذیلی ثقافت (Subculture) کیا ہے؟', 'options' => ['اقدار سے خالی ثقافت', 'غیر ملکی ثقافت', 'بڑی ثقافت کے اندر ایک چھوٹی ثقافت', 'ختم شدہ ثقافت'], 'correct' => 2],
                ],
                'Socialization' => [
                    ['q' => 'معاشرے کی اقدار اور اصول سیکھنے کے عمل کو کیا کہتے ہیں؟', 'options' => ['شہرکاری', 'سماج کاری (Socialization)', 'صنعت کاری', 'ہجرت'], 'correct' => 1],
                    ['q' => '\'Looking-glass self\' کا تصور کس نے پیش کیا؟', 'options' => ['چارلس ہارٹن کولے', 'کارل مارکس', 'ایمائل ڈرکھائم', 'آگسٹ کومٹے'], 'correct' => 0],
                    ['q' => '\'I\' اور \'Me\' کے تصورات کس سے منسوب ہیں؟', 'options' => ['میکس ویبر', 'ابنِ خلدون', 'ہربرٹ اسپنسر', 'جارج ہربرٹ میڈ'], 'correct' => 3],
                    ['q' => 'درج ذیل میں سے سماج کاری کا ذریعہ (Agent) کون سا ہے؟', 'options' => ['موسم', 'آتش فشاں', 'ہم عمر ساتھی (Peer Group)', 'سمندر'], 'correct' => 2],
                    ['q' => 'ابتدائی بچپن میں سب سے زیادہ اثر کس کا ہوتا ہے؟', 'options' => ['ذرائع ابلاغ', 'خاندان', 'دفتر', 'سیاسی جماعت'], 'correct' => 1],
                    ['q' => 'انتہائی تنہائی میں پلنے والے بچوں کے واقعات کیا ظاہر کرتے ہیں؟', 'options' => ['انسانی نشوونما کے لیے سماجی میل جول ضروری ہے', 'زبان خود بخود آ جاتی ہے', 'سماج کاری غیر ضروری ہے', 'صرف جینز رویہ طے کرتے ہیں'], 'correct' => 0],
                ],
                'Social Groups & Institutions' => [
                    ['q' => '\'بنیادی گروہ\' (Primary Group) کی اصطلاح کس نے متعارف کرائی؟', 'options' => ['میکس ویبر', 'کارل مارکس', 'ہربرٹ اسپنسر', 'چارلس ہارٹن کولے'], 'correct' => 3],
                    ['q' => '\'اپنا گروہ\' اور \'غیر گروہ\' (In-group / Out-group) کی اصطلاحات کس نے دیں؟', 'options' => ['ایمائل ڈرکھائم', 'آگسٹ کومٹے', 'ولیم گراہم سمنر', 'رابرٹ مرٹن'], 'correct' => 2],
                    ['q' => 'ثانوی گروہ (Secondary Group) کی مثال کون سی ہے؟', 'options' => ['خاندان', 'مزدور یونین', 'قریبی دوستوں کا حلقہ', 'بچپن کے کھیل کے ساتھی'], 'correct' => 1],
                    ['q' => 'سماجی ادارہ (Social Institution) کیا ہے؟', 'options' => ['معاشرے کی بنیادی ضروریات پوری کرنے والے اصولوں کا منظم نظام', 'ایک عمارت', 'وقتی اجتماع', 'ذاتی مشغلہ'], 'correct' => 0],
                    ['q' => 'طاقت، قانون اور نظم و ضبط کو کون سا ادارہ منظم کرتا ہے؟', 'options' => ['خاندان', 'مذہب', 'تفریحی ادارہ', 'سیاسی ادارہ'], 'correct' => 3],
                    ['q' => 'سب سے زیادہ عالمگیر سماجی ادارہ کون سا ہے؟', 'options' => ['اسٹاک مارکیٹ', 'کھیل کا کلب', 'خاندان', 'سیاسی جماعت'], 'correct' => 2],
                ],
                'Social Change' => [
                    ['q' => 'سماجی تبدیلی سے کیا مراد ہے؟', 'options' => ['بالکل ایک جیسا رہنا', 'وقت کے ساتھ سماجی ڈھانچے اور تعلقات میں تبدیلی', 'موسم کی تبدیلی', 'صرف لباس کی تبدیلی'], 'correct' => 1],
                    ['q' => 'سست اور بتدریج تبدیلی کو کیا کہتے ہیں؟', 'options' => ['ارتقا', 'انقلاب', 'بغاوت', 'ہنگامہ'], 'correct' => 0],
                    ['q' => 'معاشرے میں تیز اور بنیادی تبدیلی کو کیا کہتے ہیں؟', 'options' => ['ارتقا', 'جمود', 'روایت', 'انقلاب'], 'correct' => 3],
                    ['q' => 'سماجی تبدیلی کا ایک اہم سبب کون سا ہے؟', 'options' => ['جامد رسوم', 'صرف تنہائی', 'ٹیکنالوجی', 'خاموشی'], 'correct' => 2],
                    ['q' => 'ایک معاشرے سے دوسرے میں ثقافتی عناصر کے پھیلنے کو کیا کہتے ہیں؟', 'options' => ['ثقافتی تاخیر', 'ثقافتی پھیلاؤ (Cultural Diffusion)', 'نسلی تعصب', 'اندرونِ شادی'], 'correct' => 1],
                    ['q' => 'سماجی تحریک (Social Movement) کیا ہے؟', 'options' => ['تبدیلی لانے یا روکنے کے لیے منظم اجتماعی کوشش', 'نجی سفر', 'چھٹی', 'خاندانی کھانا'], 'correct' => 0],
                    ['q' => 'صنعت کاری عام طور پر کس کا باعث بنتی ہے؟', 'options' => ['دیہی تنہائی', 'پیشوں میں کوئی تبدیلی نہیں', 'مشینوں کے استعمال میں کمی', 'شہرکاری اور خاندانی ڈھانچے میں تبدیلی'], 'correct' => 3],
                ],
            ],
            '2nd Year Education (Urdu)' => [
                'Concept of Education' => [
                    ['q' => 'اسکولوں میں منصوبہ بند نصاب اور سندوں کے ساتھ دی جانے والی تعلیم کیا کہلاتی ہے؟', 'options' => ['غیر رسمی تعلیم', 'اتفاقی سیکھنا', 'رسمی تعلیم', 'ہم عمر ساتھیوں سے گپ شپ'], 'correct' => 2],
                    ['q' => 'روزمرہ زندگی، خاندان اور معاشرے سے بغیر مقررہ نصاب کے سیکھنا کیا کہلاتا ہے؟', 'options' => ['رسمی تعلیم', 'غیر رسمی تعلیم', 'جامعاتی تعلیم', 'فنی تعلیم'], 'correct' => 1],
                    ['q' => 'باقاعدہ تعلیمی نظام سے باہر چلنے والے بالغوں کی خواندگی کے پروگرام کیا کہلاتے ہیں؟', 'options' => ['غیر رسمی (Non-formal) تعلیم', 'رسمی تعلیم', 'پری اسکول تعلیم', 'اعلیٰ تعلیم'], 'correct' => 0],
                    ['q' => 'تعلیم کو بہترین طور پر کس عمل سے تعبیر کیا جا سکتا ہے؟', 'options' => ['ایک دن کا واقعہ', 'دس سال کی عمر پر ختم ہونے والا عمل', 'میٹرک پر ختم ہونے والا عمل', 'تاحیات جاری رہنے والا عمل'], 'correct' => 3],
                    ['q' => 'تعلیم کو \'انسان کی فطری صلاحیتوں کی ہم آہنگ اور بتدریج نشوونما\' کس نے کہا؟', 'options' => ['پاؤلوف', 'سکنر', 'پیسٹالوزی', 'بلوم'], 'correct' => 2],
                    ['q' => 'تعلیم کا ایک بنیادی کام کیا ہے؟', 'options' => ['قیمتیں بڑھانا', 'ثقافت اور علم کو اگلی نسل تک منتقل کرنا', 'آبادی کم کرنا', 'تبدیلی کو روکنا'], 'correct' => 1],
                ],
                'Aims & Objectives of Education' => [
                    ['q' => 'تعلیمی مقاصد (Aims) کا کام کیا ہے؟', 'options' => ['تعلیمی عمل کو سمت دینا', 'کوئی اہمیت نہیں', 'صرف طلبہ طے کرتے ہیں', 'ہر منٹ بدلتے ہیں'], 'correct' => 0],
                    ['q' => 'مقاصد (Aims) اور اہداف (Objectives) میں کیا فرق ہے؟', 'options' => ['مقاصد مخصوص؛ اہداف وسیع', 'دونوں بالکل ایک ہیں', 'مقاصد صرف اساتذہ کے لیے ہیں', 'مقاصد وسیع اور طویل مدتی؛ اہداف مخصوص اور مختصر مدتی'], 'correct' => 3],
                    ['q' => 'تعلیمی اہداف کی مشہور درجہ بندی (Taxonomy) کس نے پیش کی؟', 'options' => ['ژاں پیاژے', 'ایوان پاؤلوف', 'بنجمن بلوم', 'جان ڈیوی'], 'correct' => 2],
                    ['q' => 'بلوم کی درجہ بندی کے تین دائرے (Domains) کون سے ہیں؟', 'options' => ['طبعی، کیمیائی اور حیاتیاتی', 'ذہنی، جذباتی اور حرکی', 'سماجی، سیاسی اور معاشی', 'بصری، سمعی اور لسانی'], 'correct' => 1],
                    ['q' => 'رویوں، دلچسپیوں اور اقدار سے متعلق دائرہ کون سا ہے؟', 'options' => ['جذباتی دائرہ (Affective)', 'ذہنی دائرہ (Cognitive)', 'حرکی دائرہ (Psychomotor)', 'جسمانی دائرہ'], 'correct' => 0],
                    ['q' => 'جسمانی مہارتوں اور ہم آہنگی سے متعلق دائرہ کون سا ہے؟', 'options' => ['جذباتی دائرہ', 'ذہنی دائرہ', 'اخلاقی دائرہ', 'حرکی دائرہ (Psychomotor)'], 'correct' => 3],
                    ['q' => 'تعلیم کا پیشہ ورانہ مقصد کس پر توجہ دیتا ہے؟', 'options' => ['صرف نظمیں یاد کرنا', 'تفریح', 'افراد کو روزگار کے لیے تیار کرنا', 'کام سے بچنا'], 'correct' => 2],
                ],
                'Curriculum & Teaching Methods' => [
                    ['q' => 'تدریس کا کون سا طریقہ زیادہ تر استاد مرکوز ہوتا ہے؟', 'options' => ['پروجیکٹ کا طریقہ', 'لیکچر کا طریقہ', 'سرگرمی کا طریقہ', 'دریافتی طریقہ'], 'correct' => 1],
                    ['q' => 'تدریس کا پروجیکٹ میتھڈ کس سے منسوب ہے؟', 'options' => ['ولیم کلپیٹرک', 'ایوان پاؤلوف', 'میکس ویبر', 'آگسٹ کومٹے'], 'correct' => 0],
                    ['q' => 'سبق کا منصوبہ (Lesson Plan) کیا ہے؟', 'options' => ['طالب علم کا ٹائم ٹیبل', 'امتحانی پرچہ', 'اسکول کا نقشہ', 'استاد کا کیا اور کیسے پڑھانا ہے، اس کا منظم خاکہ'], 'correct' => 3],
                    ['q' => '\'پوشیدہ نصاب\' (Hidden Curriculum) سے کیا مراد ہے؟', 'options' => ['سرکاری نصابی کتاب', 'امتحانی نصاب', 'اسکول میں غیر تحریری طور پر سیکھے جانے والے اسباق اور اقدار', 'خفیہ امتحانی سوالات'], 'correct' => 2],
                    ['q' => 'کون سا طریقہ سیکھنے والے کو عمل کے مرکز میں رکھتا ہے؟', 'options' => ['صرف لیکچر', 'سرگرمی پر مبنی تعلیم', 'صرف رٹا لگانا', 'صرف خاموش مطالعہ'], 'correct' => 1],
                    ['q' => 'سمعی و بصری امدادی اشیا تدریس میں بنیادی طور پر کیا کام کرتی ہیں؟', 'options' => ['تصورات کو واضح اور دلچسپ بناتی ہیں', 'سبق کو طویل کرتی ہیں', 'استاد کی جگہ مکمل لے لیتی ہیں', 'طلبہ کی ضرورت ختم کرتی ہیں'], 'correct' => 0],
                    ['q' => 'نصاب کے عناصر میں کون سے شامل ہیں؟', 'options' => ['صرف کرسیاں اور میزیں', 'صرف گھنٹی', 'صرف اسکول کی فیس', 'مقاصد، مواد، طریقے اور جانچ'], 'correct' => 3],
                ],
                'Educational Psychology' => [
                    ['q' => 'تعلیمی نفسیات کس کا مطالعہ ہے؟', 'options' => ['چٹانوں کا', 'سیاروں کی حرکت کا', 'سیکھنے اور سکھانے کے رویّے کا', 'اسٹاک مارکیٹ کا'], 'correct' => 2],
                    ['q' => 'کلاسیکی مشروط تعلیم (Classical Conditioning) کس سے منسوب ہے؟', 'options' => ['بی۔ ایف۔ سکنر', 'ایوان پاؤلوف', 'ژاں پیاژے', 'ابراہم میسلو'], 'correct' => 1],
                    ['q' => 'عملی مشروط تعلیم (Operant Conditioning) کس سے منسوب ہے؟', 'options' => ['بی۔ ایف۔ سکنر', 'ایوان پاؤلوف', 'سگمنڈ فرائیڈ', 'بنجمن بلوم'], 'correct' => 0],
                    ['q' => 'ذہنی نشوونما کے مراحل کا نظریہ کس ماہرِ نفسیات نے دیا؟', 'options' => ['ایوان پاؤلوف', 'ایڈورڈ تھارنڈائیک', 'میکس ویبر', 'ژاں پیاژے'], 'correct' => 3],
                    ['q' => 'پیاژے کے نظریے میں پہلا مرحلہ کون سا ہے؟', 'options' => ['رسمی عملی مرحلہ', 'ٹھوس عملی مرحلہ', 'حسّی حرکی مرحلہ (Sensorimotor)', 'پیش عملی مرحلہ'], 'correct' => 2],
                    ['q' => 'تھارنڈائیک کا \'قانونِ اثر\' (Law of Effect) کیا کہتا ہے؟', 'options' => ['سیکھنے سے رویہ نہیں بدلتا', 'جس رویّے کے بعد اطمینان ملے وہ دہرایا جاتا ہے', 'مشق کا کوئی اثر نہیں', 'انعام سیکھنا کم کرتا ہے'], 'correct' => 1],
                    ['q' => '\'ضروریات کا درجہ وار نظام\' (Hierarchy of Needs) کس نے پیش کیا؟', 'options' => ['ابراہم میسلو', 'ژاں پیاژے', 'ایوان پاؤلوف', 'جان لاک'], 'correct' => 0],
                    ['q' => 'سیکھنے میں تحریک (Motivation) سے کیا مراد ہے؟', 'options' => ['اسکول کی چھٹی', 'امتحان کی ایک قسم', 'تدریسی امداد', 'اندرونی جذبہ جو سیکھنے والے کو مقصد کی طرف بڑھاتا ہے'], 'correct' => 3],
                ],
                'Education System in Pakistan' => [
                    ['q' => 'پاکستان میں ابتدائی تعلیم عام طور پر کن جماعتوں پر مشتمل ہوتی ہے؟', 'options' => ['چھٹی سے آٹھویں', 'نویں اور دسویں', 'پہلی سے پانچویں', 'گیارہویں اور بارہویں'], 'correct' => 2],
                    ['q' => 'پاکستان میں ثانوی تعلیم (میٹرک) کن جماعتوں پر مشتمل ہے؟', 'options' => ['پہلی اور دوسری', 'نویں اور دسویں', 'گیارہویں اور بارہویں', 'چودہویں اور سولہویں'], 'correct' => 1],
                    ['q' => 'ہائر ایجوکیشن کمیشن (HEC) پاکستان کب قائم ہوا؟', 'options' => ['2002ء', '1947ء', '1973ء', '2018ء'], 'correct' => 0],
                    ['q' => 'آئینِ پاکستان کا آرٹیکل 25-A کس کی ضمانت دیتا ہے؟', 'options' => ['مفت رہائش', 'سب کے لیے مفت ٹرانسپورٹ', 'صرف مفت طبی ڈگریاں', '5 سے 16 سال کے بچوں کے لیے مفت اور لازمی تعلیم'], 'correct' => 3],
                    ['q' => 'پاکستان میں میٹرک اور انٹرمیڈیٹ کے امتحانات کون لیتا ہے؟', 'options' => ['پاکستان ریلوے', 'اسٹیٹ بینک', 'تعلیمی بورڈ', 'الیکشن کمیشن'], 'correct' => 2],
                    ['q' => 'پاکستان کی کون سی جامعہ فاصلاتی تعلیم کے لیے مشہور ہے؟', 'options' => ['کراچی بندرگاہ', 'علامہ اقبال اوپن یونیورسٹی', 'واپڈا', 'لاہور چڑیا گھر'], 'correct' => 1],
                    ['q' => 'مدرسہ تعلیم بنیادی طور پر کس پر توجہ دیتی ہے؟', 'options' => ['دیگر مضامین کے ساتھ دینی تعلیم', 'صرف ہوابازی', 'صرف کھیل', 'صرف کھانا پکانا'], 'correct' => 0],
                ],
            ],
            '2nd Year Sociology (Urdu)' => [
                'Social Institutions' => [
                    ['q' => 'پانچ بنیادی سماجی ادارے کون سے ہیں؟', 'options' => ['سنیما، کھیل، موسیقی، فیشن اور فن', 'بینک، دکان، فیکٹری، کھیت اور مال', 'اسکول، پارک، سڑک، بازار اور ہسپتال', 'خاندان، مذہب، تعلیم، معیشت اور سیاست'], 'correct' => 3],
                    ['q' => 'تعلیمی ادارے کا بنیادی کام کیا ہے؟', 'options' => ['ٹیکس جمع کرنا', 'قانون بنانا', 'علم، مہارتوں اور اقدار کی منتقلی', 'صرف شادی کو منظم کرنا'], 'correct' => 2],
                    ['q' => 'معاشی ادارے کا تعلق کس سے ہے؟', 'options' => ['عبادت سے', 'اشیا اور خدمات کی پیداوار، تقسیم اور کھپت سے', 'صرف بچوں کی پرورش سے', 'صرف تفریح سے'], 'correct' => 1],
                    ['q' => 'سیاسی ادارہ بنیادی طور پر کس سے متعلق ہے؟', 'options' => ['اقتدار، اختیار اور حکمرانی سے', 'کھیتی باڑی سے', 'کھانا پکانے سے', 'فیشن سے'], 'correct' => 0],
                    ['q' => 'ظاہری (Manifest) اور پوشیدہ (Latent) افعال میں فرق کس ماہرِ عمرانیات نے کیا؟', 'options' => ['آگسٹ کومٹے', 'ابنِ خلدون', 'چارلس کولے', 'رابرٹ کے۔ مرٹن'], 'correct' => 3],
                    ['q' => 'سماجی ادارے اہم کیوں ہیں؟', 'options' => ['یہ انتشار پیدا کرتے ہیں', 'یہ تمام قواعد ختم کرتے ہیں', 'یہ معاشرے کی بنیادی ضروریات کے لیے رویّوں کو منظم کرتے ہیں', 'یہ تعاون روکتے ہیں'], 'correct' => 2],
                ],
                'Family & Marriage' => [
                    ['q' => 'والدین، بچوں اور دیگر رشتہ داروں کے ساتھ رہنے والا خاندان کیا کہلاتا ہے؟', 'options' => ['مرکزی خاندان', 'مشترکہ (وسیع) خاندان', 'صرف ایک والدین والا خاندان', 'کارپوریٹ خاندان'], 'correct' => 1],
                    ['q' => 'ایک مرد کی ایک سے زیادہ عورتوں سے شادی کو کیا کہتے ہیں؟', 'options' => ['تعدد ازدواج (Polygyny)', 'یک زوجگی', 'ایک عورت کی کئی شوہروں سے شادی', 'اندرونِ شادی'], 'correct' => 0],
                    ['q' => 'اپنے ہی گروہ، ذات یا برادری کے اندر شادی کو کیا کہتے ہیں؟', 'options' => ['بیرونِ شادی (Exogamy)', 'یک زوجگی', 'تعدد ازدواج', 'اندرونِ شادی (Endogamy)'], 'correct' => 3],
                    ['q' => 'اپنے گروہ سے باہر شادی کو کیا کہتے ہیں؟', 'options' => ['اندرونِ شادی (Endogamy)', 'یک زوجگی', 'بیرونِ شادی (Exogamy)', 'تعدد ازواج'], 'correct' => 2],
                    ['q' => 'پدرسری (Patriarchal) خاندان میں اختیار بنیادی طور پر کس کے پاس ہوتا ہے؟', 'options' => ['سب سے بزرگ عورت', 'سب سے بزرگ مرد', 'سب سے چھوٹے بچے', 'پڑوسیوں'], 'correct' => 1],
                ],
                'Religion & Society' => [
                    ['q' => 'ڈرکھائم نے مذہبی اشیا کو کن دو اقسام میں تقسیم کیا؟', 'options' => ['مقدس اور غیر مقدس', 'اچھی اور بری', 'امیر اور غریب', 'پرانی اور نئی'], 'correct' => 0],
                    ['q' => '\'پروٹسٹنٹ اخلاقیات اور سرمایہ داری کی روح\' کس کی تصنیف ہے؟', 'options' => ['کارل مارکس', 'آگسٹ کومٹے', 'ایمائل ڈرکھائم', 'میکس ویبر'], 'correct' => 3],
                    ['q' => 'مذہب کو \'عوام کی افیون\' کس نے کہا؟', 'options' => ['میکس ویبر', 'چارلس کولے', 'کارل مارکس', 'ابنِ خلدون'], 'correct' => 2],
                    ['q' => 'مذہب کا ایک سماجی کام کیا ہے؟', 'options' => ['تمام اصول ختم کرنا', 'سماجی ہم آہنگی اور مشترکہ اقدار کو فروغ دینا', 'صرف عدم مساوات پیدا کرنا', 'رابطہ روکنا'], 'correct' => 1],
                    ['q' => 'سیکولرائزیشن (Secularisation) سے کیا مراد ہے؟', 'options' => ['عوامی زندگی میں مذہب کے اثر کا کم ہونا', 'ہر جگہ مذہب کا بڑھنا', 'عبادت کی ایک قسم', 'ایک مقدس کتاب'], 'correct' => 0],
                    ['q' => 'توحید (Monotheism) سے مراد کس پر ایمان ہے؟', 'options' => ['کئی خداؤں پر', 'کسی خدا پر نہیں', 'صرف فطری روحوں پر', 'ایک خدا پر'], 'correct' => 3],
                    ['q' => 'ماہرینِ عمرانیات مذہب کا مطالعہ بنیادی طور پر کس حیثیت سے کرتے ہیں؟', 'options' => ['صرف ذاتی راز کے طور پر', 'سائنسی تجربے کے طور پر', 'ایک سماجی ادارے کے طور پر', 'معاشی پروڈکٹ کے طور پر'], 'correct' => 2],
                ],
                'Social Problems' => [
                    ['q' => 'غربت ایسی حالت ہے جس میں لوگ:', 'options' => ['ضرورت سے زیادہ وسائل رکھتے ہیں', 'بنیادی ضروریات پوری کرنے کے وسائل نہیں رکھتے', 'کھانے کے محتاج نہیں ہوتے', 'اونچی آمدنی رکھتے ہیں'], 'correct' => 1],
                    ['q' => 'نوعمر جرائم (Juvenile Delinquency) سے کیا مراد ہے؟', 'options' => ['نوجوانوں کا قانون شکنی کرنا', 'بچوں کی فرمانبرداری', 'اسکول کی حاضری', 'کھیل کی سرگرمی'], 'correct' => 0],
                    ['q' => 'درج ذیل میں سے سماجی مسئلہ کون سا ہے؟', 'options' => ['موسمی بارش', 'طلوعِ آفتاب', 'سمندری مدوجزر', 'نشے کی لت'], 'correct' => 3],
                    ['q' => 'بدعنوانی (Corruption) سے کیا مراد ہے؟', 'options' => ['دیانتدارانہ خدمت', 'ٹیکس ادا کرنا', 'ذاتی فائدے کے لیے سرکاری عہدے کا غلط استعمال', 'ووٹ ڈالنا'], 'correct' => 2],
                    ['q' => 'بے روزگاری اس وقت ہوتی ہے جب:', 'options' => ['سب کے پاس ملازمت ہو', 'کام کے قابل اور خواہش مند افراد کو ملازمت نہ ملے', 'لوگ گھر سے نکلنے سے انکار کریں', 'اسکول چھٹیوں پر بند ہوں'], 'correct' => 1],
                    ['q' => 'جرائم جیسے سماجی مسائل کا ایک بڑا سبب اکثر کیا ہوتا ہے؟', 'options' => ['غربت اور مواقع کی کمی', 'سب کے لیے اچھی تعلیم', 'مستحکم ملازمتیں', 'مضبوط سماجی تعاون'], 'correct' => 0],
                ],
                'Population & Urbanisation' => [
                    ['q' => 'آبادیات (Demography) کس کا مطالعہ ہے؟', 'options' => ['چٹانوں کا', 'ستاروں کا', 'مشینوں کا', 'انسانی آبادی کا'], 'correct' => 3],
                    ['q' => 'کس نے کہا کہ آبادی ہندسی رفتار سے اور خوراک حسابی رفتار سے بڑھتی ہے؟', 'options' => ['کارل مارکس', 'میکس ویبر', 'تھامس مالتھس', 'ایمائل ڈرکھائم'], 'correct' => 2],
                    ['q' => 'خام شرحِ پیدائش (Crude Birth Rate) فی کتنے افراد سالانہ پیدائشوں کی تعداد ہوتی ہے؟', 'options' => ['فی 100 افراد ماہانہ', 'فی 1000 افراد', 'فی 10 افراد روزانہ', 'فی دس لاکھ افراد دس سال میں'], 'correct' => 1],
                    ['q' => 'شہرکاری (Urbanisation) سے کیا مراد ہے؟', 'options' => ['شہروں میں رہنے والی آبادی کے تناسب کا بڑھنا', 'شہروں سے دیہات جانا', 'شہری آبادی کا گھٹنا', 'کھیتی باڑی کا پھیلاؤ'], 'correct' => 0],
                    ['q' => 'آباد ہونے کے لیے ایک جگہ سے دوسری جگہ منتقل ہونے کو کیا کہتے ہیں؟', 'options' => ['شرحِ اموات', 'زرخیزی', 'شرحِ خواندگی', 'ہجرت'], 'correct' => 3],
                    ['q' => 'تیز شہرکاری کا ایک عام مسئلہ کون سا ہے؟', 'options' => ['ضرورت سے زیادہ کھلی زمین', 'گاڑیوں کی کمی', 'ہجوم اور کچی آبادیاں', 'مکانوں کی کم مانگ'], 'correct' => 2],
                ],
                'Research Methods' => [
                    ['q' => 'مفروضہ (Hypothesis) کیا ہے؟', 'options' => ['ثابت شدہ حتمی قانون', 'متغیرات کے درمیان تعلق کا قابلِ جانچ بیان', 'اخباری مضمون', 'بلا مقصد اندازہ'], 'correct' => 1],
                    ['q' => 'سوالنامہ (Questionnaire) کیا ہے؟', 'options' => ['معلومات جمع کرنے کے لیے تحریری سوالات کا مجموعہ', 'ایک قسم کا نقشہ', 'شماریاتی فارمولا', 'تحقیقی بجٹ'], 'correct' => 0],
                    ['q' => 'شرکتی مشاہدے (Participant Observation) میں محقق:', 'options' => ['گروہ سے کبھی نہیں ملتا', 'صرف پرانی کتابیں پڑھتا ہے', 'صرف کمپیوٹر استعمال کرتا ہے', 'جس گروہ کا مطالعہ کر رہا ہو اس میں شامل ہو جاتا ہے'], 'correct' => 3],
                    ['q' => 'نمونہ (Sample) کیا ہے؟', 'options' => ['پوری آبادی', 'تحقیق کا عنوان', 'پوری آبادی میں سے منتخب چھوٹا گروہ', 'حتمی رپورٹ'], 'correct' => 2],
                    ['q' => 'آمنے سامنے سوال پوچھ کر معلومات جمع کرنے کا طریقہ کون سا ہے؟', 'options' => ['پودوں پر تجربہ', 'انٹرویو', 'دوربین سے سروے', 'کیمیائی تجزیہ'], 'correct' => 1],
                    ['q' => 'کیس اسٹڈی (Case Study) میں کیا ہوتا ہے؟', 'options' => ['کسی ایک فرد، گروہ یا واقعے کا گہرائی سے مطالعہ', 'لاکھوں افراد کا فوری سروے', 'ستاروں کی گنتی', 'بارش کی پیمائش'], 'correct' => 0],
                    ['q' => 'کون سا کمیتی (Quantitative) تحقیقی آلہ ہے؟', 'options' => ['صرف کھلی ڈائری', 'نظم کا تجزیہ', 'غیر رسمی گفتگو', 'عددی ڈیٹا والا سروے'], 'correct' => 3],
                ],
            ],
        ];
    }
}
