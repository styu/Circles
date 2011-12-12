<?php


# Default login information
$GLOBALS['mysql']['host'] = 'sql.mit.edu';
//athena username
$GLOBALS['mysql']['user'] = '';
//sql password
$GLOBALS['mysql']['pass'] = "";
$GLOBALS['db']['prompt_table'] = 'prompts';
$GLOBALS['db']['choice_table'] = 'choices';
//you need to manually create the database. scripts is silly.
$GLOBALS['db']['db_name'] = $GLOBALS['mysql']['user'].'+circles';

function db_default_connection()
{
    global $GLOBALS;
    $_sql = $GLOBALS['mysql'];
    $link = mysql_connect($_sql['host'],$_sql['user'],$_sql['pass'])
        or trigger_error('Could not connect to MySQL: ' . mysql_error());
    return $link;
}

/**	
 * Creates a database with the given name.
 * This function should be called before creating or modifying tables.
 *
 * @param dbname $dbname The name of the database to create.
 */
function db_setup($link)
{

	$dbname = $GLOBALS['db']['db_name'];
    $SQL_STRING = "CREATE DATABASE IF NOT EXISTS $dbname";

    $result = mysql_query($SQL_STRING, db_default_connection())

        or print('could not create database: ' . mysql_error());


}
function db_setup_connections_table($link) {
	$db_info = $GLOBALS['db'];   
    mysql_select_db($db_info['db_name'], $link);
	//mysql_query("DROP TABLE `$db_info[prompt_table]`");
    $SQL_STRING = "CREATE TABLE IF NOT EXISTS `$db_info[prompt_table]` (
					  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
					  `text` varchar(255) NOT NULL,
					  `poem` varchar(255) NOT NULL,
					  `choice1` int(6) unsigned zerofill NOT NULL,
					  `choice2` int(6) unsigned zerofill NOT NULL,
					  `choice3` int(6) unsigned zerofill NOT NULL,
					  `nextPrompt` int(6) unsigned zerofill NOT NULL,
					  PRIMARY KEY (`id`)
					)";
                    
    $result = mysql_query($SQL_STRING, $link) 
        or trigger_error('Could not create table: ' . mysql_error());
	
	$SQL_STRING = "CREATE TABLE IF NOT EXISTS `$db_info[choice_table]` (
					  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
					  `text` varchar(255) NOT NULL,
					  `promptID` int(6) unsigned zerofill NOT NULL,
					  `character` int(11) NOT NULL,
					  `distance` int(11) NOT NULL,
					  `size` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
	
	$result = mysql_query($SQL_STRING, $link) 
        or trigger_error('Could not create table: ' . mysql_error());
}
function db_insert_prompts(){
	$db_info = $GLOBALS['db'];
	$link = db_default_connection();
	mysql_select_db($db_info['db_name'], $link);
	mysql_query("TRUNCATE TABLE `$db_info[prompt_table]`");
	$SQL_STRING = "INSERT INTO `$db_info[prompt_table]` (`id`, `text`, `poem`, `choice1`, `choice2`, `choice3`, `nextPrompt`) VALUES
(000001, 'You are born', 'Night mix with day, a shadow made', 000000, 000000, 000000, 000002),
(000002, 'It''s your first day of first grade. You walk into the classroom. Where do you sit? Next to...', 'Where to start, to get afar', 000001, 000002, 000003, 000000),
(000003, 'You sit down next to black, who doesn''t acknowledge your presence. You decide to...', 'Confronted by a solemn wall, someone who won''t call', 000004, 000005, 000006, 000000),
(000004, 'You sit down next to green, turns to you and tells you his/her name. You respond by...', '', 000007, 000008, 000009, 000000),
(000005, 'You sit down next to pink, who turns to you and begins to make fun of you. You respond by...', '', 000010, 000011, 000012, 000000),
(000006, 'You sit silently throughout class. Soon the bell rings and it''s time for lunch. You enter the cafeteria and decide to sit beside...', 'Forcing solitude, until a better time draws', 000013, 000014, 000015, 000000),
(000007, 'You have made a new friend! Soon the bell rings and it''s time for lunch. You enter the cafeteria, and black asks sit with you at lunch. You decide to sit beside...', '', 000013, 000014, 000016, 000000),
(000008, 'You have made a new friend! Soon the bell rings and it''s time for lunch. You enter the cafeteria, and green asks sit with you at lunch. You decide to sit beside...', '', 000013, 000015, 000017, 000000),
(000009, 'Green turns away from you and class begins. Soon the bell rings and it''s time for lunch. You enter the cafeteria and decide to sit beside...', '', 000013, 000014, 000015, 000000),
(000010, 'Pink turns away from you and class begins. Soon the bell rings and it''s time for lunch. You enter the cafeteria and decide to sit beside...', '', 000013, 000014, 000015, 000000),
(000011, 'Black continues to ignore you and class begins. Soon the bell rings and it''s time for lunch. You enter the cafeteria and decide to site beside...', '', 000013, 000014, 000015, 000000),
(000012, 'Green glares at you in response to the insult and you both sit in silence throughout class. Soon the bell rings and it''s time for lunch. You enter the cafeteria and decide to sit beside...', '', 000013, 000014, 000015, 000000),
(000013, 'Pink glares at you in response to the insult and you both sit in silence throughout class. Soon the bell rings and it''s time for lunch. You enter the cafeteria and decide to sit beside...', '', 000013, 000014, 000015, 000000),
(000014, 'You have made a new friend! Soon the bell rings and it''s time for lunch. You enter the cafeteria, and pink asks sit with you at lunch. You decide to sit beside...', '', 000014, 000015, 000018, 000000),
(000015, 'You decide to sit next to red. After opening your lunch box, you decide to...', 'Perhaps a chance to redeem', 000019, 000020, 000021, 000000),
(000016, 'You decide to sit next to orange. After opening your lunch box, you decide to...', '', 000022, 000023, 000024, 000000),
(000017, 'You decide to sit next to blue. After opening your lunch box, you decide to...', '', 000025, 000026, 000027, 000000),
(000018, 'You sit with your new friend, black. After opening your lunch box, you decide to...', '', 000036, 000029, 000030, 000000),
(000019, 'You sit with your new friend, green. After opening your lunch box, you decide to...', '', 000036, 000031, 000032, 000000),
(000020, 'You sit with your new friend, pink. After opening your lunch box, you decide to...', '', 000036, 000033, 000034, 000000),
(000021, 'As you sit silently, red steals your cookie and you finish the rest of your lonely lunch in silence.', 'Yet, only your blood spilled, hoping to heal', 000000, 000000, 000000, 000042),
(000022, 'Red punches you in the face for stealing a sip of red''s drink. Consequently red gets in trouble, and you finish the rest of your lunch in silence.', '', 000000, 000000, 000000, 000042),
(000023, 'You have made a new friend! You have an awesome first lunch with red.', '', 000000, 000000, 000000, 000042),
(000024, 'Blue turns to you and asks ''What are you doing here?''. You respond by...', '', 000035, 000028, 000000, 000000),
(000025, 'You just left Blue, where will you sit next?', '', 000013, 000014, 000000, 000000),
(000026, 'Blue sits there and ignores you.', '', 000000, 000000, 000000, 000042),
(000027, 'You have made a new friend! You have an awesome first lunch with blue.', '', 000000, 000000, 000000, 000042),
(000028, 'After you steal a sip from blue, he doesn''t notice and you feel guilty.', '', 000000, 000000, 000000, 000042),
(000029, 'You have made a new friend! You have an awesome first lunch with orange.', '', 000000, 000000, 000000, 000042),
(000030, 'Orange tells you that if you give him a cookie, he''ll be your friend.', '', 000038, 000039, 000000, 000000),
(000031, 'You sit silently next to orange for the rest of lunch.', '', 000000, 000000, 000000, 000042),
(000032, 'After you steal a sip of orange''s drink, he catches you and tell you to give him a cookie or he''ll tell the teacher', '', 000040, 000039, 000042, 000000),
(000033, '(END) Orange tells the teacher and you''re in trouble and you get suspended', '', 000000, 000000, 000000, 999999),
(000034, 'Orange hits you for lying and he gets in trouble.', '', 000000, 000000, 000000, 000042),
(000035, 'You and your friend sit awkwardly in silence.', '', 000000, 000000, 000000, 000042),
(000036, 'Green takes the cookie and offers you candy in return.', '', 000000, 000000, 000000, 000042),
(000037, 'Pink takes the cookie and glorifies in his awesomeness.', '', 000000, 000000, 000000, 000042),
(000038, 'Black ignores the offer.', '', 000000, 000000, 000000, 000042),
(000039, 'Green catches you stealing a sip, but forgives you and gives you the entire drink in return', '', 000000, 000000, 000000, 000042),
(000040, 'Pink catches you stealing a sip and begins crying.', '', 000000, 000000, 000000, 000042),
(000041, 'Black see you taking a sip, but does nothing.', '', 000000, 000000, 000000, 000042),
(000042, 'It is recess time, but it is raining heavily so you and your classmates are playing indoors. You decide to...', 'The weather spur you to choose one who care', 000043, 000044, 000045, 000000),
(000043, 'You sit down next to red and play with your toy, and red really likes your toy and asks to play with it.', 'They test your will for compassion', 000046, 000047, 000000, 000000),
(000044, 'You sit down next to pink and play with your toy, and pink really likes your toy and just takes it to play with it.', '', 000048, 000049, 000050, 000000),
(000045, 'You sit down next to green and play with your toy, and green starts to play with you by sharing his toys.', '', 000051, 000052, 000053, 000000),
(000046, 'You gained a new friend! You have a great time playing with your toy with red.', 'And measure the circle that grows', 000000, 000000, 000000, 000057),
(000047, 'Red really wanted your toy and because you didn''t share, he gets mad and breaks your toy.', '', 000054, 000055, 000056, 000000),
(000048, 'Pink gets in trouble for stealing your toy. You stand up and decide to sit next to?', '', 000043, 000045, 000000, 000000),
(000049, 'Pink is impressed with your bravery for standing up for yourself, You gained a new friend!', '', 000000, 000000, 000000, 000057),
(000050, 'Pink revels in his power over others, You sort of gain a new friend!', '', 000000, 000000, 000000, 000057),
(000051, 'Green catches you stealing his toy, but he doesn''t care and rather gives you his toy.', '', 000000, 000000, 000000, 000057),
(000052, 'You gained a new friend! You have a great time playing with your toy with green.', '', 000000, 000000, 000000, 000057),
(000053, 'You go around and decide to sit next to?', '', 000043, 000044, 000000, 000000),
(000054, 'Red gets in trouble and you get up and decide to sit next to?', '', 000044, 000045, 000000, 000000),
(000055, 'Red enjoys a good fight and you guys have a lot of fun roughing it up. You gained a new friend!', '', 000000, 000000, 000000, 000057),
(000056, 'Red thinks you''re a loser and gets up and leaves, and you''re alone, crying...', '', 000000, 000000, 000000, 000057),
(000057, 'You''re in high school, and it''s midterms week. You realize your math test is tomorrow. You decide to:', 'But sometimes edges are met', 000057, 000058, 000059, 000000),
(000058, 'You pick up the phone and decide to...', 'So you smooth it out', 000060, 000061, 000062, 000000),
(000059, 'You go to bed and at the test the next day you:', '', 000063, 000064, 000065, 000000),
(000060, 'You study really hard, but the next day you look at the test and dont understand anything, you:', '', 000063, 000066, 000064, 000000),
(000061, 'Black knows his math, and helps you study,you get an A', 'Into that once perfect shape ', 000067, 000068, 000000, 000000),
(000062, 'You and blue study together and you both get an B', '', 000069, 000070, 000000, 000000),
(000063, 'Orange doesn''t seem to know anything and you end up helping him study, he gets an A and you get a C', '', 000071, 000072, 000073, 000000),
(000064, 'You cheat off of who''s test?', '', 000074, 000075, 000076, 000000),
(000065, '(END) You failed the test', '', 000059, 000000, 000000, 999999),
(000066, 'You get an A on the test through your own efforts and someone asks you to help them for the next test.', '', 000000, 000000, 000000, 000077),
(000067, 'After cheating off of black, you get an A; he knows you copied his answers, but he doesn''t care', '', 000000, 000000, 000000, 000077),
(000068, '(END) After cheating off of pink, you get an A; he knows you copied his answers, and he tells on you. You''re suspended', '', 000064, 000000, 000000, 999999),
(000069, 'After cheating off of red, you get an C; he tried cheating off of you, so both of you got wrong answers.', '', 000000, 000000, 000000, 000077),
(000070, 'You appreciate black and value him as more just just a tool.', 'Even if only temporarily', 000000, 000000, 000000, 000077),
(000071, 'You''re just using black.', '', 000000, 000000, 000000, 000077),
(000072, 'You''re mad at blue because you didn''t get an A, so you never study with blue again.', '', 000000, 000000, 000000, 000077),
(000073, 'You and blue both celebrate because you guys got B''s!!!', '', 000000, 000000, 000000, 000077),
(000074, 'The teacher doesn''t believe orange cheated', '', 000000, 000000, 000000, 000078),
(000075, 'You and orange get in a fist fight', '', 000000, 000000, 000000, 000078),
(000076, 'You forget about the incident', '', 000000, 000000, 000000, 000077),
(000077, 'Orange decides to celebrate the end of midterms and throws a party, inviting the whole school including you.', 'It grows and envelops ', 000077, 000079, 000000, 000000),
(000078, 'Orange decides to celebrate the end of midterms and throws a party, inviting the whole school including you, although with a sinister smile. You decide to:', '', 000078, 000079, 000000, 000000),
(000079, 'You walk into the house, and decide to...', 'As you step into a new realm', 000080, 000091, 000092, 000000),
(000080, 'Pink decides to challenges blue, who is weak, to arm wrestling, you:', 'Where sacrifices fill the void', 000081, 000082, 000083, 000000),
(000081, 'You do nothing but watch on as blue gets humiliated. Then you decide to:', 'Overwhelmed by indecisiveness', 000084, 000085, 000086, 000000),
(000082, 'You and pink have a good laugh as blue loses terribly, you gain a friend! You then decide:', '', 000087, 000088, 000089, 000000),
(000083, '(BLUE) You slam pink into the ground, and saves blue from humiliation; you guys end up being best friends.', '', 000000, 000000, 000000, 999999),
(000084, '(BLUE) You and blue end up having a good time at the party and become best friends.', 'Eventually an end, your circle, tint Blue', 000000, 000000, 000000, 999999),
(000085, '(PINK) After congratulating pink, you guys hang out and start talking about how awesome each other is.', '', 000000, 000000, 000000, 999999),
(000086, '(ALONE) You didn''t really feel like doing anything, and nothing really interests you, so you end up alone.', '', 000000, 000000, 000000, 999999),
(000087, '(PINK) You and pink have a good time and start talking about how awesome you guys are.', '', 000000, 000000, 000000, 999999),
(000088, 'You decide pink is boring, so you leave and:', '', 000090, 000091, 000102, 000000),
(000089, 'You walk over to orange just as red is trying to pick a fight with orange', '', 000093, 000094, 000095, 000000),
(000090, '(RED) You help red by punching orange in the face, and you and red leave the party to have fun elsewhere', '', 000000, 000000, 000000, 999999),
(000091, '(ORANGE) You help orange by telling red to cool it, and orange appreciates your help and you guys have a good time', '', 000000, 000000, 000000, 999999),
(000092, '(ALONE) You watched as the two fight it out and afterward you have no one to talk to', '', 000000, 000000, 000000, 999999),
(000093, 'Red is drunk and offers you a beer:', '', 000096, 000097, 000098, 000000),
(000094, '(RED) You and red get really drunk and have lots of laughs, and meet up every weekend to get drunk', '', 000000, 000000, 000000, 999999),
(000095, 'Red asks you to go to a room upstairs, you:', '', 000099, 000100, 000000, 000000),
(000096, 'After leaving red, you decide to:', '', 000101, 000103, 000102, 000000),
(000097, '(RED) You didn''t want to drink in front of others but you end up taking the beer, and you guys get chummy', '', 000000, 000000, 000000, 999999),
(000098, 'After leaving red, you decide to:', '', 000000, 000000, 000000, 000000),
(000099, 'You walk over to green while he''s telling a story and he''s about to reach the punchline and you:', '', 000104, 000105, 000106, 000000),
(000100, '(GREEN) You and green continue laughing and you guys have a good time', '', 000000, 000000, 000000, 999999),
(000101, 'Green looks a bit disconcerted and orange sticks up for green, you decide to:', '', 000107, 000108, 000000, 000000),
(000102, 'you leave green and decide to:', '', 000101, 000103, 000000, 000000),
(000103, '(GREEN) (ORANGE) You, green, and orange have a good time at the party.', '', 000000, 000000, 000000, 999999),
(000104, 'After you decide to not be at the party, black calls and invites you to go to a haunted house. You decide to', '', 000110, 000109, 000000, 000000),
(000105, '(ALONE) You stay home halloween and do nothing special.', '', 000104, 000000, 000000, 999999),
(000106, 'You arrive at the haunted house. Some people ditched the party to join you. Black asks who wants to go in with him. You:', '', 000111, 000112, 000113, 000000),
(000107, 'You walk inside, following black, go up the stairs into some creepy attic, where black lights a cigarette and he offers you one you:', '', 000114, 000115, 000000, 000000),
(000108, '(BLACK) You and black hit it off and smoke together for the rest of the year', '', 000000, 000000, 000000, 999999),
(000109, '(ALONE) You decide to leave.', '', 000000, 000000, 000000, 000000),
(000110, 'Blue goes in. You hear a scream. You:', '', 000116, 000117, 000118, 000000),
(000111, '(BLUE) Blue had seen a rat. You comfort blue and have a lot of fun.', '', 000000, 000000, 000000, 999999),
(000112, '(ALONE) Black comes out laughing at you, while holding a recording of a scream. You leave.', '', 000110, 000000, 000000, 999999),
(000113, 'Red comes up to you and tell you that its a prank, and brings you to the party. You decide to:', '', 000080, 000091, 000092, 000000),
(000114, 'You follow everyone in. You see everyone smoking and they ask you if you want to join. You:', '', 000119, 000120, 000000, 000000),
(000115, 'You leave and sneak into the party. You decide to:', '', 000080, 000091, 000092, 000000),
(000116, '(BLACK) Black is impressed with you, and you guys have a lot of fun.', '', 000000, 000000, 000000, 999999),
(000117, 'As you arrive at the party, orange gets a bunch of his friends to throw you into the pool. You decide to:', '', 000121, 000122, 000123, 000000),
(000118, 'You and Orange have a good laugh and turn the party into a pool party. You hang out with:', '', 000124, 000091, 000080, 000000),
(000119, 'Blue stands up for you. You decide to:', '', 000135, 000136, 000000, 000000),
(000120, 'You start talking to Orange and you choose to talk about:', '', 000127, 000128, 000129, 000000),
(000121, 'As you guys talk about the test, tension builds and you decide to:', '', 000131, 000130, 000000, 000000),
(000122, '(ORANGE) You find that you and orange have a lot in common, and become best friends and forget the past.', '', 000000, 000000, 000000, 999999),
(000123, 'Orange gets bored and leaves, so you go toward:', '', 000000, 000000, 000000, 999999),
(000124, 'You walk over to green and he is completely drunk and puking, so you:', '', 000132, 000133, 000134, 000000),
(000125, '(ALONE) You feel that no one is fun to talk to so you leave.', '', 000121, 000000, 000000, 999999),
(000126, '(GREEN) He quickly recovers the next day and you guys are really good friends.', '', 000000, 000000, 000000, 999999),
(000127, '(BLUE) Blue helps you out the water and you guys leave the party and chill.', '', 000000, 000000, 000000, 999999),
(000128, '(ALONE) Blue gives you a look and walks away, and you leave the party soaking wet, only to return home to solitude.', '', 000119, 000000, 000000, 999999)";
	$result = mysql_query($SQL_STRING, $link)
		or trigger_error('Could not insert values: ' . mysql_error());
}

function db_insert_choices(){
	$db_info = $GLOBALS['db'];
	$link = db_default_connection();
	mysql_select_db($db_info['db_name'], $link);
	mysql_query("TRUNCATE TABLE $db_info[choice_table]");
	$SQL_STRING = "INSERT INTO `$db_info[choice_table]` (`id`, `text`, `promptID`, `character`, `distance`, `size`) VALUES
(000001, 'Black', 000003, 0, 0, 0),
(000002, 'Green', 000004, 0, 0, 0),
(000003, 'Pink', 000005, 0, 0, 0),
(000004, 'Do nothing', 000006, 0, 0, 0),
(000005, 'Introduce yourself to black', 000007, 0, 0, 0),
(000006, 'Make fun of black''s face', 000011, 0, 0, 0),
(000007, 'Introducing yourself as well', 000008, 3, 1, 1),
(000008, 'Doing nothing', 000009, 0, 0, 0),
(000009, 'Make fun of green''s face', 000012, 3, -1, -1),
(000010, 'Doing nothing', 000010, 0, 0, 0),
(000011, 'Making fun of pink''s face', 000013, 6, -1, -1),
(000012, 'Introducing yourself', 000014, 6, 1, 1),
(000013, 'Red', 000015, 0, 0, 0),
(000014, 'Orange', 000016, 0, 0, 0),
(000015, 'Blue', 000017, 0, 0, 0),
(000016, 'Black', 000018, 1, 1, 0),
(000017, 'Green', 000019, 3, 1, 0),
(000018, 'Pink', 000020, 6, 1, 0),
(000019, 'Sit and eat your lunch silently', 000021, 0, 0, 0),
(000020, 'Offer red a cookie', 000023, 4, 1, 1),
(000021, 'Steal a sip from red''s drink', 000022, 4, -1, -1),
(000022, 'Sit and eat your lunch silently', 000030, 0, 0, 0),
(000023, 'Offer orange a cookie', 000029, 5, 1, 1),
(000024, 'Steal a sip from orange''s drink', 000032, 5, -1, -1),
(000025, 'Sit and eat your lunch silently', 000024, 0, 0, 0),
(000026, 'Offer blue a cookie', 000027, 2, 1, 1),
(000027, 'Steal a sip from blue''s drink', 000028, 2, 0, -1),
(000028, 'Sit silently', 000026, 0, 0, 0),
(000029, 'Offer black a cookie', 000038, 1, 1, 1),
(000030, 'Steal a sip from black''s drink', 000041, 1, -1, -1),
(000031, 'Offer green a cookie', 000036, 3, 1, 1),
(000032, 'Steal a sip from green''s drink', 000039, 3, 0, -1),
(000033, 'Offer pink a cookie', 000037, 6, 0, 1),
(000034, 'Steal a sip from pink''s drink', 000040, 6, -1, -1),
(000035, 'leave blue to himself', 000025, 2, -1, 0),
(000036, 'sit silently and eat your lunch', 000035, 0, 0, 0),
(000037, 'hide and be lonely', 000000, 0, 0, 0),
(000038, 'you give orange the cookie', 000029, 5, 1, 1),
(000039, 'you don''t give orange the cookie', 000033, 5, -1, -1),
(000040, 'you give begrudgingly give orange the cookie', 000029, 5, 1, 1),
(000041, 'you don''t give orange the cookie', 000000, 5, -1, -1),
(000042, 'You lie and tell the teacher that orange tried to steal your cookie', 000034, 5, -1, -1),
(000043, 'Play next to red', 000043, 0, 0, 0),
(000044, 'Play next to pink', 000044, 0, 0, 0),
(000045, 'Play next to green', 000045, 0, 0, 0),
(000046, 'Share with red', 000046, 4, 1, 1),
(000047, 'Don''t share with red', 000047, 4, -1, -1),
(000048, 'you tell on pink', 000048, 6, -1, -1),
(000049, 'you take pink''s toy', 000049, 6, 1, 1),
(000050, 'you let pink play with your toy', 000050, 6, 1, 1),
(000051, 'steal green''s toy', 000051, 3, 1, -1),
(000052, 'play with green', 000052, 3, 1, 1),
(000053, 'you leave', 000053, 0, 0, 0),
(000054, 'You tell on red', 000054, 4, -1, -1),
(000055, 'You start fighting with red', 000055, 4, 1, 1),
(000056, 'You cry', 000056, 0, 0, 0),
(000057, 'Call someone to study', 000058, 0, 0, 0),
(000058, 'Forget it, math is too hard', 000059, 0, 0, 0),
(000059, 'Study by yourself', 000060, 0, 0, 0),
(000060, 'Call black', 000061, 1, 1, 0),
(000061, 'Call blue', 000062, 2, 1, 0),
(000062, 'Call orange', 000063, 5, 1, 0),
(000063, 'cheat', 000064, 0, 0, 0),
(000064, 'sleep', 000065, 0, 0, 0),
(000065, 'guess', 000065, 0, 0, 0),
(000066, 'try harder', 000066, 0, 0, 0),
(000067, 'Thank black for his help', 000070, 1, 1, 1),
(000068, 'Ignore thereafter', 000071, 1, 1, -1),
(000069, 'You wanted an A, not B!', 000072, 2, -1, -1),
(000070, 'HIGH FIVE!', 000073, 2, 1, 1),
(000071, 'You lie to the teacher and say orange cheated.', 000074, 5, -1, -1),
(000072, 'You punch orange out of anger.', 000075, 5, -1, -1),
(000073, 'You move on with life.', 000076, 0, 0, 0),
(000074, 'cheat off of black', 000067, 0, 0, 0),
(000075, 'cheat off of pink', 000068, 0, 0, 0),
(000076, 'cheat off of red', 000069, 0, 0, 0),
(000077, 'You decide to go', 000079, 0, 0, 0),
(000078, 'You begrudgingly decide to go', 000117, 0, 0, 0),
(000079, 'You decide to not go', 000104, 0, 0, 0),
(000080, 'Walk towards pink', 000080, 0, 0, 0),
(000081, 'do nothing', 000081, 0, 0, 0),
(000082, 'cheer pink on.', 000082, 6, 1, 1),
(000083, 'take blue''s place', 000083, 2, 1, 1),
(000084, 'feel bad for blue and decide to comfort him', 000084, 2, 1, 1),
(000085, 'laugh at blue for being a loser and congratulate pink', 000085, 6, 1, 1),
(000086, 'say nothing', 000086, 0, 0, 0),
(000087, 'keep talking to pink', 000087, 6, 1, 1),
(000088, 'you get bored of pink', 000088, 6, -1, 0),
(000089, 'you leave the party', 000104, 0, 0, 0),
(000090, 'Walk towards orange', 000089, 0, 0, 0),
(000091, 'Walk towards red', 000093, 0, 0, 0),
(000092, 'Walk towards green', 000099, 0, 0, 0),
(000093, 'You run over and help red', 000090, 4, 1, 1),
(000094, 'You decide to help orange', 000091, 5, 1, 1),
(000095, 'You do nothing but watch the fight', 000092, 0, 0, 0),
(000096, 'chug it', 000094, 4, 1, 1),
(000097, 'decline and just chat', 000095, 0, 0, 0),
(000098, 'leave red to his drunkeness', 000096, 4, -1, 0),
(000099, 'go wih red to upstairs', 000097, 4, 1, 1),
(000100, 'tell him to go away', 000096, 4, -1, -1),
(000101, 'go to orange', 000089, 0, 0, 0),
(000102, 'Walk towards green', 000099, 0, 0, 0),
(000103, 'leave the party', 000104, 0, 0, 0),
(000104, 'let him tell it because you think its good', 000100, 3, 1, 1),
(000105, 'interrupt', 000101, 3, -1, -1),
(000106, 'listen and say it''s stupid', 000102, 3, -1, -1),
(000107, 'apologize to green', 000103, 3, 1, 1),
(000108, 'leave and back down', 000102, 0, 0, 0),
(000109, 'Don''t go', 000105, 1, -1, -1),
(000110, 'Go', 000106, 1, 1, 1),
(000111, 'Go with black', 000107, 1, 1, 1),
(000112, 'volunteer someone else', 000110, 0, 0, 0),
(000113, 'stay quiet', 000114, 0, 0, 0),
(000114, 'you smoke it', 000108, 1, 1, 1),
(000115, 'you say no', 000115, 1, -1, -1),
(000116, 'run inside', 000111, 2, 1, 1),
(000117, 'run away', 000112, 0, 0, 0),
(000118, 'freeze in fear', 000113, 0, 0, 0),
(000119, 'leave', 000115, 0, 0, 0),
(000120, 'join in', 000116, 1, 1, 1),
(000121, 'leave the party', 000104, 5, -1, -1),
(000122, 'pull orange into the pool with you', 000118, 5, 1, 1),
(000123, 'do nothing', 000119, 5, -1, -1),
(000124, 'orange', 000120, 0, 0, 0),
(000125, 'red', 000000, 0, 0, 0),
(000126, 'pink', 000000, 0, 0, 0),
(000127, 'the test', 000121, 5, -1, -1),
(000128, 'something in common', 000122, 5, 1, 1),
(000129, 'make small talk', 000123, 0, 0, 0),
(000130, 'leave orange', 000125, 5, -1, -1),
(000131, 'go toward green', 000124, 0, 0, 0),
(000132, 'get disgusted and leave', 000125, 3, -1, -1),
(000133, 'help him by getting him water', 000126, 3, 1, 1),
(000134, 'call for help', 000126, 3, 1, 1),
(000135, 'accept blue''s help', 000127, 2, 1, 1),
(000136, 'decline his help', 000128, 2, -1, -1)";
	
	$result = mysql_query($SQL_STRING, $link)
		or trigger_error('Could not insert values: ' . mysql_error());
	
	
}
?>