<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Verified starter question bank for the Punjab Board of Intermediate
 * subjects. The (Urdu) variants carry Urdu-medium questions so the
 * practice screen matches the medium of the subject.
 */
class McqBoardSeeder extends Seeder
{
    use SeedsMcqs;

    public function run(): void
    {
        $this->seedBank($this->bank());
    }

    private function bank(): array
    {
        return [
            '1st Year Biology' => [
                'Introduction to Biology' => [
                    ['q' => 'Which branch of biology deals with the study of tissues?', 'options' => ['Histology', 'Cytology', 'Embryology', 'Taxonomy'], 'correct' => 0],
                    ['q' => 'The study of fossils is called...', 'options' => ['Palaeontology', 'Ecology', 'Genetics', 'Physiology'], 'correct' => 0],
                ],
                'Biological Molecules' => [
                    ['q' => 'Which element is present in proteins but not in carbohydrates?', 'options' => ['Carbon', 'Hydrogen', 'Nitrogen', 'Oxygen'], 'correct' => 2],
                    ['q' => 'The building blocks of proteins are...', 'options' => ['Fatty acids', 'Amino acids', 'Monosaccharides', 'Nucleotides'], 'correct' => 1],
                ],
                'Enzymes' => [
                    ['q' => 'Enzymes are mostly made of...', 'options' => ['Lipids', 'Proteins', 'Carbohydrates', 'Minerals'], 'correct' => 1],
                    ['q' => 'An enzyme works by...', 'options' => ['Raising activation energy', 'Lowering activation energy', 'Changing the products', 'Adding heat'], 'correct' => 1],
                ],
                'The Cell' => [
                    ['q' => 'Which organelle is known as the powerhouse of the cell?', 'options' => ['Ribosome', 'Mitochondrion', 'Nucleus', 'Golgi body'], 'correct' => 1],
                    ['q' => 'Which structure is present in plant cells but absent in animal cells?', 'options' => ['Cell wall', 'Nucleus', 'Mitochondrion', 'Cell membrane'], 'correct' => 0],
                ],
                'Bioenergetics' => [
                    ['q' => 'In which organelle does photosynthesis take place?', 'options' => ['Mitochondrion', 'Chloroplast', 'Lysosome', 'Vacuole'], 'correct' => 1],
                ],
            ],

            '1st Year Chemistry' => [
                'Basic Concepts of Chemistry' => [
                    ['q' => 'What is the value of Avogadro\'s number?', 'options' => ['6.02 x 10^23', '3.14 x 10^8', '9.8 x 10^5', '1.6 x 10^-19'], 'correct' => 0],
                    ['q' => 'One mole of any substance contains how many particles?', 'options' => ['1000', 'Avogadro\'s number of particles', '100', 'Depends on the element'], 'correct' => 1],
                ],
                'Atomic Structure' => [
                    ['q' => 'Which subatomic particle carries a negative charge?', 'options' => ['Proton', 'Neutron', 'Electron', 'Positron'], 'correct' => 2],
                    ['q' => 'The atomic number of an element equals the number of...', 'options' => ['Neutrons', 'Protons', 'Nucleons', 'Electrons in the outer shell'], 'correct' => 1],
                ],
                'Chemical Bonding' => [
                    ['q' => 'A bond formed by the transfer of electrons is called...', 'options' => ['Covalent bond', 'Ionic bond', 'Metallic bond', 'Hydrogen bond'], 'correct' => 1],
                    ['q' => 'A covalent bond is formed by...', 'options' => ['Transfer of electrons', 'Sharing of electrons', 'Loss of protons', 'Attraction of neutrons'], 'correct' => 1],
                ],
                'States of Matter' => [
                    ['q' => 'Boyle\'s law states that at constant temperature, pressure is...', 'options' => ['Directly proportional to volume', 'Inversely proportional to volume', 'Equal to volume', 'Independent of volume'], 'correct' => 1],
                ],
                'Solutions' => [
                    ['q' => 'Molarity is defined as moles of solute per...', 'options' => ['Litre of solution', 'Kilogram of solvent', 'Gram of solute', 'Mole of solvent'], 'correct' => 0],
                ],
            ],

            '1st Year Computer Science' => [
                'Basics of Information Technology' => [
                    ['q' => 'What does IT stand for?', 'options' => ['Information Technology', 'Internet Terminal', 'Integrated Transfer', 'Input Tool'], 'correct' => 0],
                    ['q' => 'Data that has been processed into a meaningful form is called...', 'options' => ['Raw data', 'Information', 'A file', 'A signal'], 'correct' => 1],
                ],
                'Computer Components' => [
                    ['q' => 'Which unit of the CPU performs calculations?', 'options' => ['Control unit', 'ALU', 'Register', 'Bus'], 'correct' => 1],
                ],
                'Storage Devices' => [
                    ['q' => 'Which of these is a secondary storage device?', 'options' => ['RAM', 'Cache', 'Hard disk', 'Register'], 'correct' => 2],
                    ['q' => 'One gigabyte is approximately equal to...', 'options' => ['1024 KB', '1024 MB', '1024 bytes', '1024 TB'], 'correct' => 1],
                ],
                'Operating Systems' => [
                    ['q' => 'The main job of an operating system is to...', 'options' => ['Design web pages', 'Manage hardware and software resources', 'Edit photos', 'Print documents only'], 'correct' => 1],
                ],
                'Data Communication & Networks' => [
                    ['q' => 'Which device connects two different networks together?', 'options' => ['Router', 'Monitor', 'Scanner', 'Printer'], 'correct' => 0],
                ],
                'Introduction to Programming' => [
                    ['q' => 'A step-by-step procedure to solve a problem is called...', 'options' => ['A flowchart symbol', 'An algorithm', 'A compiler', 'A variable'], 'correct' => 1],
                ],
            ],

            '1st Year English' => [
                'Parts of Speech' => [
                    ['q' => 'In the sentence "She sings beautifully", the word "beautifully" is a...', 'options' => ['Noun', 'Adjective', 'Adverb', 'Verb'], 'correct' => 2],
                    ['q' => 'Which word is a preposition?', 'options' => ['quickly', 'under', 'happy', 'run'], 'correct' => 1],
                ],
                'Tenses' => [
                    ['q' => 'Which sentence is in the present perfect tense?', 'options' => ['He writes a letter.', 'He has written a letter.', 'He wrote a letter.', 'He is writing a letter.'], 'correct' => 1],
                    ['q' => 'Choose the correct sentence.', 'options' => ['He go to school daily.', 'He goes to school daily.', 'He going to school daily.', 'He gone to school daily.'], 'correct' => 1],
                ],
                'Active & Passive Voice' => [
                    ['q' => 'Change to passive voice: "Ali writes a letter."', 'options' => ['A letter is written by Ali.', 'A letter was written by Ali.', 'A letter writes Ali.', 'Ali is written a letter.'], 'correct' => 0],
                ],
                'Direct & Indirect Speech' => [
                    ['q' => 'He said, "I am tired." Change into indirect speech.', 'options' => ['He said that I am tired.', 'He said that he was tired.', 'He says he is tired.', 'He told that he is tired.'], 'correct' => 1],
                ],
                'Synonyms & Antonyms' => [
                    ['q' => 'Which word is the closest synonym of "abundant"?', 'options' => ['Scarce', 'Plentiful', 'Weak', 'Narrow'], 'correct' => 1],
                    ['q' => 'What is the antonym of "generous"?', 'options' => ['Kind', 'Selfish', 'Helpful', 'Noble'], 'correct' => 1],
                ],
            ],

            '1st Year Islamiat' => [
                'Quran & Its Teachings' => [
                    ['q' => 'How many Surahs are there in the Holy Quran?', 'options' => ['110', '114', '120', '124'], 'correct' => 1],
                    ['q' => 'The first revelation of the Holy Quran was received in which cave?', 'options' => ['Cave of Thawr', 'Cave of Hira', 'Cave of Uhud', 'Cave of Safa'], 'correct' => 1],
                ],
                'Seerat-un-Nabi (SAW)' => [
                    ['q' => 'In which city was the Holy Prophet (SAW) born?', 'options' => ['Madinah', 'Makkah', 'Taif', 'Jeddah'], 'correct' => 1],
                    ['q' => 'The migration of the Holy Prophet (SAW) from Makkah to Madinah is called...', 'options' => ['Hajj', 'Hijrah', 'Umrah', 'Fath'], 'correct' => 1],
                ],
                'Pillars of Islam' => [
                    ['q' => 'How many pillars of Islam are there?', 'options' => ['3', '4', '5', '6'], 'correct' => 2],
                    ['q' => 'Which pillar of Islam is an obligatory charity?', 'options' => ['Salah', 'Zakat', 'Sawm', 'Hajj'], 'correct' => 1],
                ],
                'Hadith & Sunnah' => [
                    ['q' => 'The sayings of the Holy Prophet (SAW) are known as...', 'options' => ['Hadith', 'Ijma', 'Qiyas', 'Fiqh'], 'correct' => 0],
                ],
            ],

            '1st Year Mathematics' => [
                'Number Systems' => [
                    ['q' => 'Which of these is an irrational number?', 'options' => ['1/2', '0.75', 'Square root of 2', '-4'], 'correct' => 2],
                    ['q' => 'In the complex number a + bi, "b" is called the...', 'options' => ['Real part', 'Imaginary part', 'Modulus', 'Argument'], 'correct' => 1],
                ],
                'Sets, Functions & Groups' => [
                    ['q' => 'If a set has n elements, how many subsets does it have?', 'options' => ['n', '2n', '2^n', 'n^2'], 'correct' => 2],
                    ['q' => 'A set with no elements is called...', 'options' => ['A singleton set', 'An empty set', 'A universal set', 'A power set'], 'correct' => 1],
                ],
                'Matrices & Determinants' => [
                    ['q' => 'A matrix with equal numbers of rows and columns is called...', 'options' => ['Row matrix', 'Square matrix', 'Null matrix', 'Diagonal matrix only'], 'correct' => 1],
                    ['q' => 'A matrix is singular when its determinant is...', 'options' => ['1', '0', 'Negative', 'Undefined'], 'correct' => 1],
                ],
                'Quadratic Equations' => [
                    ['q' => 'The discriminant of ax^2 + bx + c = 0 is...', 'options' => ['b^2 - 4ac', '4ac - b^2', 'b^2 + 4ac', '2a'], 'correct' => 0],
                ],
                'Trigonometry' => [
                    ['q' => 'What is the value of sin^2 x + cos^2 x?', 'options' => ['0', '1', '2', 'tan x'], 'correct' => 1],
                ],
            ],

            '1st Year Physics' => [
                'Measurements' => [
                    ['q' => 'How many base units are there in the SI system?', 'options' => ['5', '6', '7', '9'], 'correct' => 2],
                    ['q' => 'Which is the SI unit of force?', 'options' => ['Joule', 'Newton', 'Watt', 'Pascal'], 'correct' => 1],
                ],
                'Vectors & Equilibrium' => [
                    ['q' => 'Which of these is a vector quantity?', 'options' => ['Speed', 'Mass', 'Velocity', 'Temperature'], 'correct' => 2],
                    ['q' => 'The dot product of two perpendicular vectors is...', 'options' => ['Maximum', 'Zero', 'One', 'Negative'], 'correct' => 1],
                ],
                'Motion & Force' => [
                    ['q' => 'Newton\'s first law of motion is also called the law of...', 'options' => ['Inertia', 'Acceleration', 'Action and reaction', 'Gravitation'], 'correct' => 0],
                    ['q' => 'The SI unit of momentum is...', 'options' => ['kg m/s', 'N/s', 'J s', 'm/s^2'], 'correct' => 0],
                ],
                'Work, Energy & Power' => [
                    ['q' => 'The SI unit of power is...', 'options' => ['Joule', 'Newton', 'Watt', 'Pascal'], 'correct' => 2],
                    ['q' => 'Work is done only when...', 'options' => ['A force acts and the body is displaced', 'A force acts with no displacement', 'The body is at rest', 'The force is zero'], 'correct' => 0],
                ],
                'Waves & Oscillations' => [
                    ['q' => 'Sound waves are...', 'options' => ['Transverse waves', 'Longitudinal waves', 'Electromagnetic waves', 'Standing waves only'], 'correct' => 1],
                ],
            ],

            '1st Year Sociology (Eng)' => [
                'Introduction to Sociology' => [
                    ['q' => 'Who is known as the father of sociology?', 'options' => ['Karl Marx', 'Auguste Comte', 'Max Weber', 'Emile Durkheim'], 'correct' => 1],
                    ['q' => 'Sociology is the scientific study of...', 'options' => ['Human society and social behaviour', 'The human body', 'Ancient fossils', 'Economic policy only'], 'correct' => 0],
                ],
                'Culture' => [
                    ['q' => 'Which of these is an example of non-material culture?', 'options' => ['Buildings', 'Beliefs and values', 'Tools', 'Clothing'], 'correct' => 1],
                ],
                'Socialization' => [
                    ['q' => 'Which is the primary agent of socialization?', 'options' => ['School', 'Family', 'Media', 'Workplace'], 'correct' => 1],
                ],
                'Social Groups & Institutions' => [
                    ['q' => 'A small group with close, face-to-face relationships is called...', 'options' => ['Secondary group', 'Primary group', 'Reference group', 'Formal group'], 'correct' => 1],
                ],
            ],

            '1st Year Sociology (Urdu)' => [
                'Introduction to Sociology' => [
                    ['q' => 'عمرانیات کا بانی کس کو کہا جاتا ہے؟', 'options' => ['کارل مارکس', 'آگسٹ کومٹے', 'میکس ویبر', 'ایمائل ڈرکھائم'], 'correct' => 1],
                    ['q' => 'عمرانیات کس چیز کا مطالعہ کرتی ہے؟', 'options' => ['انسانی معاشرہ اور سماجی رویہ', 'انسانی جسم', 'قدیم فوسلز', 'صرف معاشی پالیسی'], 'correct' => 0],
                ],
                'Culture' => [
                    ['q' => 'غیر مادی ثقافت کی مثال کون سی ہے؟', 'options' => ['عمارتیں', 'عقائد اور اقدار', 'اوزار', 'لباس'], 'correct' => 1],
                ],
                'Socialization' => [
                    ['q' => 'سماج کاری کا سب سے بنیادی ادارہ کون سا ہے؟', 'options' => ['اسکول', 'خاندان', 'ذرائع ابلاغ', 'دفتر'], 'correct' => 1],
                ],
                'Social Groups & Institutions' => [
                    ['q' => 'جس گروہ میں قریبی اور آمنے سامنے کے تعلقات ہوں وہ کہلاتا ہے؟', 'options' => ['ثانوی گروہ', 'بنیادی گروہ', 'حوالہ گروہ', 'رسمی گروہ'], 'correct' => 1],
                ],
            ],

            '2nd Year Biology' => [
                'Homeostasis' => [
                    ['q' => 'Which organ is the main excretory organ in humans?', 'options' => ['Liver', 'Kidney', 'Lung', 'Skin'], 'correct' => 1],
                    ['q' => 'The functional unit of the kidney is the...', 'options' => ['Neuron', 'Nephron', 'Alveolus', 'Villus'], 'correct' => 1],
                ],
                'Coordination & Control' => [
                    ['q' => 'The structural and functional unit of the nervous system is the...', 'options' => ['Nephron', 'Neuron', 'Axon only', 'Synapse'], 'correct' => 1],
                    ['q' => 'Which gland is called the master gland?', 'options' => ['Thyroid', 'Pituitary', 'Adrenal', 'Pancreas'], 'correct' => 1],
                ],
                'Support & Movement' => [
                    ['q' => 'How many bones are there in an adult human body?', 'options' => ['186', '206', '226', '256'], 'correct' => 1],
                ],
                'Inheritance & Genetics' => [
                    ['q' => 'Who is known as the father of genetics?', 'options' => ['Charles Darwin', 'Gregor Mendel', 'Louis Pasteur', 'Robert Hooke'], 'correct' => 1],
                    ['q' => 'How many chromosomes are present in a normal human body cell?', 'options' => ['23', '44', '46', '48'], 'correct' => 2],
                ],
                'Evolution & Ecosystem' => [
                    ['q' => 'The theory of natural selection was proposed by...', 'options' => ['Lamarck', 'Charles Darwin', 'Mendel', 'Aristotle'], 'correct' => 1],
                ],
            ],

            '2nd Year Chemistry' => [
                'Periodic Classification' => [
                    ['q' => 'The modern periodic table is arranged in order of increasing...', 'options' => ['Atomic mass', 'Atomic number', 'Density', 'Valency'], 'correct' => 1],
                    ['q' => 'Elements of group 18 are known as...', 'options' => ['Halogens', 'Noble gases', 'Alkali metals', 'Transition metals'], 'correct' => 1],
                ],
                's & p Block Elements' => [
                    ['q' => 'Which group contains the alkali metals?', 'options' => ['Group 1', 'Group 2', 'Group 17', 'Group 18'], 'correct' => 0],
                ],
                'Organic Chemistry Basics' => [
                    ['q' => 'Organic chemistry is the study of compounds of which element?', 'options' => ['Nitrogen', 'Carbon', 'Silicon', 'Sulphur'], 'correct' => 1],
                    ['q' => 'The functional group -OH belongs to which class of compounds?', 'options' => ['Aldehydes', 'Alcohols', 'Ketones', 'Acids'], 'correct' => 1],
                ],
                'Hydrocarbons' => [
                    ['q' => 'The general formula of alkanes is...', 'options' => ['CnH2n', 'CnH2n+2', 'CnH2n-2', 'CnHn'], 'correct' => 1],
                    ['q' => 'Which hydrocarbon contains a triple bond?', 'options' => ['Alkane', 'Alkene', 'Alkyne', 'Arene'], 'correct' => 2],
                ],
            ],

            '2nd Year Computer Science' => [
                'Data Basics & Databases' => [
                    ['q' => 'What does DBMS stand for?', 'options' => ['Data Backup Management System', 'Database Management System', 'Digital Binary Memory Store', 'Data Block Module Set'], 'correct' => 1],
                    ['q' => 'A collection of related records is called a...', 'options' => ['Field', 'File', 'Byte', 'Character'], 'correct' => 1],
                ],
                'Database Design' => [
                    ['q' => 'A field that uniquely identifies each record is called a...', 'options' => ['Foreign key', 'Primary key', 'Index only', 'Composite field'], 'correct' => 1],
                ],
                'Introduction to C Language' => [
                    ['q' => 'Which function is the starting point of a C program?', 'options' => ['start()', 'main()', 'begin()', 'init()'], 'correct' => 1],
                    ['q' => 'Which function is used to print output in C?', 'options' => ['cout', 'printf()', 'echo', 'print()'], 'correct' => 1],
                ],
                'Control Structures in C' => [
                    ['q' => 'Which loop checks its condition after executing the body?', 'options' => ['for', 'while', 'do-while', 'switch'], 'correct' => 2],
                ],
                'Pointers & File Handling' => [
                    ['q' => 'Which operator returns the address of a variable in C?', 'options' => ['*', '&', '#', '->'], 'correct' => 1],
                ],
            ],

            '2nd Year Education (Eng)' => [
                'Concept of Education' => [
                    ['q' => 'The word "education" is derived from the Latin word "educare", which means...', 'options' => ['To bring up or nourish', 'To write', 'To count', 'To travel'], 'correct' => 0],
                    ['q' => 'Informal education takes place mainly through...', 'options' => ['Schools and colleges', 'Family and society', 'Examinations', 'Formal curriculum'], 'correct' => 1],
                ],
                'Aims & Objectives of Education' => [
                    ['q' => 'Which is a major aim of education?', 'options' => ['All-round development of personality', 'Only earning money', 'Only passing exams', 'Only physical training'], 'correct' => 0],
                ],
                'Curriculum & Teaching Methods' => [
                    ['q' => 'A curriculum is best described as...', 'options' => ['A single textbook', 'The planned learning experiences of an institution', 'An examination paper', 'A timetable only'], 'correct' => 1],
                ],
                'Education System in Pakistan' => [
                    ['q' => 'Which level of education comes immediately after secondary education in Pakistan?', 'options' => ['Primary', 'Higher secondary (intermediate)', 'Middle', 'Postgraduate'], 'correct' => 1],
                ],
            ],

            '2nd Year Education (Urdu)' => [
                'Concept of Education' => [
                    ['q' => 'لفظ "تعلیم" کا بنیادی مفہوم کیا ہے؟', 'options' => ['پرورش اور نشوونما کرنا', 'لکھنا', 'گننا', 'سفر کرنا'], 'correct' => 0],
                    ['q' => 'غیر رسمی تعلیم بنیادی طور پر کہاں سے حاصل ہوتی ہے؟', 'options' => ['اسکول اور کالج', 'خاندان اور معاشرہ', 'امتحانات', 'نصاب'], 'correct' => 1],
                ],
                'Aims & Objectives of Education' => [
                    ['q' => 'تعلیم کا بنیادی مقصد کیا ہے؟', 'options' => ['شخصیت کی ہمہ جہت نشوونما', 'صرف پیسہ کمانا', 'صرف امتحان پاس کرنا', 'صرف جسمانی تربیت'], 'correct' => 0],
                ],
                'Curriculum & Teaching Methods' => [
                    ['q' => 'نصاب سے کیا مراد ہے؟', 'options' => ['ایک کتاب', 'ادارے کے منظم تعلیمی تجربات', 'امتحانی پرچہ', 'صرف ٹائم ٹیبل'], 'correct' => 1],
                ],
                'Education System in Pakistan' => [
                    ['q' => 'پاکستان میں ثانوی تعلیم کے فوراً بعد کون سا درجہ آتا ہے؟', 'options' => ['ابتدائی', 'انٹرمیڈیٹ', 'مڈل', 'پوسٹ گریجوایٹ'], 'correct' => 1],
                ],
            ],

            '2nd Year English' => [
                'Tenses & Grammar' => [
                    ['q' => 'Choose the correct sentence.', 'options' => ['She have finished her work.', 'She has finished her work.', 'She having finished her work.', 'She has finish her work.'], 'correct' => 1],
                    ['q' => 'Fill in the blank: "He has been waiting ___ two hours."', 'options' => ['since', 'for', 'from', 'by'], 'correct' => 1],
                ],
                'Voice & Narration' => [
                    ['q' => 'Change to passive: "They are building a house."', 'options' => ['A house is being built by them.', 'A house was built by them.', 'A house is built by them.', 'A house has built by them.'], 'correct' => 0],
                ],
                'Vocabulary & Synonyms' => [
                    ['q' => 'What is the synonym of "brief"?', 'options' => ['Lengthy', 'Short', 'Loud', 'Heavy'], 'correct' => 1],
                    ['q' => 'What is the antonym of "victory"?', 'options' => ['Triumph', 'Defeat', 'Success', 'Win'], 'correct' => 1],
                ],
                'Idioms & Phrases' => [
                    ['q' => 'What does "once in a blue moon" mean?', 'options' => ['Very often', 'Very rarely', 'At night only', 'Every month'], 'correct' => 1],
                ],
            ],

            '2nd Year Pak Study (Eng)' => [
                'Ideology of Pakistan' => [
                    ['q' => 'The Two Nation Theory was presented by...', 'options' => ['Sir Syed Ahmad Khan', 'Mahatma Gandhi', 'Lord Mountbatten', 'Jawaharlal Nehru'], 'correct' => 0],
                    ['q' => 'Allama Iqbal presented the idea of a separate Muslim state in his address at...', 'options' => ['Lahore, 1940', 'Allahabad, 1930', 'Delhi, 1946', 'Karachi, 1947'], 'correct' => 1],
                ],
                'Pakistan Movement' => [
                    ['q' => 'The Pakistan Resolution was passed in which year?', 'options' => ['1930', '1940', '1946', '1947'], 'correct' => 1],
                    ['q' => 'The All India Muslim League was founded in which city?', 'options' => ['Lahore', 'Dhaka', 'Delhi', 'Aligarh'], 'correct' => 1],
                ],
                'Constitutional Development' => [
                    ['q' => 'Pakistan\'s first constitution was enforced in which year?', 'options' => ['1947', '1956', '1962', '1973'], 'correct' => 1],
                    ['q' => 'The present constitution of Pakistan was adopted in...', 'options' => ['1956', '1962', '1973', '1985'], 'correct' => 2],
                ],
                'Land & People of Pakistan' => [
                    ['q' => 'Which is the largest province of Pakistan by area?', 'options' => ['Punjab', 'Sindh', 'Balochistan', 'Khyber Pakhtunkhwa'], 'correct' => 2],
                ],
            ],

            '2nd Year Pak Study (Urdu)' => [
                'Ideology of Pakistan' => [
                    ['q' => 'دو قومی نظریہ سب سے پہلے کس نے پیش کیا؟', 'options' => ['سر سید احمد خان', 'مہاتما گاندھی', 'لارڈ ماؤنٹ بیٹن', 'جواہر لال نہرو'], 'correct' => 0],
                    ['q' => 'علامہ اقبال نے علیحدہ مسلم ریاست کا تصور کس خطبے میں پیش کیا؟', 'options' => ['لاہور 1940', 'الہ آباد 1930', 'دہلی 1946', 'کراچی 1947'], 'correct' => 1],
                ],
                'Pakistan Movement' => [
                    ['q' => 'قرارداد پاکستان کس سال منظور ہوئی؟', 'options' => ['1930', '1940', '1946', '1947'], 'correct' => 1],
                    ['q' => 'آل انڈیا مسلم لیگ کا قیام کس شہر میں ہوا؟', 'options' => ['لاہور', 'ڈھاکہ', 'دہلی', 'علی گڑھ'], 'correct' => 1],
                ],
                'Constitutional Development' => [
                    ['q' => 'پاکستان کا پہلا آئین کس سال نافذ ہوا؟', 'options' => ['1947', '1956', '1962', '1973'], 'correct' => 1],
                ],
                'Land & People of Pakistan' => [
                    ['q' => 'رقبے کے لحاظ سے پاکستان کا سب سے بڑا صوبہ کون سا ہے؟', 'options' => ['پنجاب', 'سندھ', 'بلوچستان', 'خیبر پختونخوا'], 'correct' => 2],
                ],
            ],

            '2nd Year Physics' => [
                'Electrostatics' => [
                    ['q' => 'The SI unit of electric charge is the...', 'options' => ['Ampere', 'Coulomb', 'Volt', 'Ohm'], 'correct' => 1],
                    ['q' => 'Coulomb\'s law states that force between two charges is inversely proportional to...', 'options' => ['The distance', 'The square of the distance', 'The cube of the distance', 'The product of charges'], 'correct' => 1],
                ],
                'Current Electricity' => [
                    ['q' => 'Ohm\'s law is expressed as...', 'options' => ['V = IR', 'V = I/R', 'I = VR', 'R = VI'], 'correct' => 0],
                    ['q' => 'The SI unit of electrical resistance is the...', 'options' => ['Volt', 'Ohm', 'Watt', 'Farad'], 'correct' => 1],
                ],
                'Electromagnetism' => [
                    ['q' => 'A moving charge produces...', 'options' => ['Only an electric field', 'A magnetic field as well', 'No field', 'Only heat'], 'correct' => 1],
                ],
                'Modern Physics' => [
                    ['q' => 'The photoelectric effect was explained by...', 'options' => ['Newton', 'Einstein', 'Bohr', 'Faraday'], 'correct' => 1],
                ],
                'Atomic & Nuclear Physics' => [
                    ['q' => 'Which particle has no electric charge?', 'options' => ['Proton', 'Electron', 'Neutron', 'Alpha particle'], 'correct' => 2],
                ],
            ],

            '2nd Year Sociology (Eng)' => [
                'Social Institutions' => [
                    ['q' => 'Which of these is a basic social institution?', 'options' => ['Family', 'Cinema', 'Shopping mall', 'Restaurant'], 'correct' => 0],
                ],
                'Family & Marriage' => [
                    ['q' => 'A family consisting of parents and their children only is called...', 'options' => ['Joint family', 'Nuclear family', 'Extended family', 'Clan'], 'correct' => 1],
                    ['q' => 'Marriage to one spouse at a time is called...', 'options' => ['Polygamy', 'Monogamy', 'Endogamy', 'Exogamy'], 'correct' => 1],
                ],
                'Social Problems' => [
                    ['q' => 'Which of these is considered a social problem?', 'options' => ['Illiteracy', 'Rainfall', 'Sunrise', 'Gravity'], 'correct' => 0],
                ],
                'Population & Urbanisation' => [
                    ['q' => 'The movement of people from villages to cities is called...', 'options' => ['Emigration', 'Urbanisation', 'Immigration', 'Migration abroad'], 'correct' => 1],
                ],
            ],

            '2nd Year Sociology (Urdu)' => [
                'Social Institutions' => [
                    ['q' => 'درج ذیل میں سے بنیادی سماجی ادارہ کون سا ہے؟', 'options' => ['خاندان', 'سینما', 'شاپنگ مال', 'ریستوران'], 'correct' => 0],
                ],
                'Family & Marriage' => [
                    ['q' => 'صرف والدین اور ان کے بچوں پر مشتمل خاندان کیا کہلاتا ہے؟', 'options' => ['مشترکہ خاندان', 'مرکزی خاندان', 'وسیع خاندان', 'قبیلہ'], 'correct' => 1],
                    ['q' => 'ایک وقت میں ایک شریک حیات سے شادی کو کیا کہتے ہیں؟', 'options' => ['تعدد ازدواج', 'یک زوجگی', 'اندرون شادی', 'بیرون شادی'], 'correct' => 1],
                ],
                'Social Problems' => [
                    ['q' => 'درج ذیل میں سے کون سا سماجی مسئلہ ہے؟', 'options' => ['ناخواندگی', 'بارش', 'طلوع آفتاب', 'کشش ثقل'], 'correct' => 0],
                ],
                'Population & Urbanisation' => [
                    ['q' => 'دیہات سے شہروں کی طرف نقل مکانی کو کیا کہتے ہیں؟', 'options' => ['ہجرت بیرون ملک', 'شہرکاری', 'آمد', 'واپسی'], 'correct' => 1],
                ],
            ],
        ];
    }
}
