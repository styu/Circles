<?php


# Default login information
$GLOBALS['mysql']['host'] = 'localhost';
$GLOBALS['mysql']['user'] = 'root';
$GLOBALS['mysql']['pass'] = "";
$GLOBALS['db']['prompt_table'] = 'prompts';
$GLOBALS['db']['choice_table'] = 'choices';
$GLOBALS['db']['db_name'] = $GLOBALS['mysql']['user'].'circles';

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
	$SQL_STRING = "INSERT INTO `$db_info[prompt_table]` (`text`) VALUES
					('You are born'),
					('It\'s your first day of first grade. You walk into the classroom. Where do you sit? Next to...'),
					('You sit down next to black, who doesn\'t acknowledge your presence. You decide to...'),
					('You sit down next to green, turns to you and tells you his/her name. You respond by...'),
					('You sit down next to pink, who turns to you and begins to make fun of you. You respond by...'),
					('You sit silently throughout class. Soon the bell rings and it\'s time for lunch. You enter the cafeteria and decide to sit beside...'),
					('You have made a new friend! Soon the bell rings and it\'s time for lunch. You enter the cafeteria, and black asks sit with you at lunch. You decide to sit beside...'),
					('You have made a new friend! Soon the bell rings and it\'s time for lunch. You enter the cafeteria, and green asks sit with you at lunch. You decide to sit beside...'),
					('Green turns away from you and class begins. Soon the bell rings and it\'s time for lunch. You enter the cafeteria and decide to sit beside...'),
					('Pink turns away from you and class begins. Soon the bell rings and it\'s time for lunch. You enter the cafeteria and decide to sit beside...'),
					('Black continues to ignore you and class begins. Soon the bell rings and it\'s time for lunch. You enter the cafeteria and decide to site beside...'),
					('Green glares at you in response to the insult and you both sit in silence throughout class. Soon the bell rings and it\'s time for lunch. You enter the cafeteria and decide to sit beside...'),
					('Pink glares at you in response to the insult and you both sit in silence throughout class. Soon the bell rings and it\'s time for lunch. You enter the cafeteria and decide to sit beside...'),
					('You have made a new friend! Soon the bell rings and it\'s time for lunch. You enter the cafeteria, and pink asks sit with you at lunch. You decide to sit beside...'),
					('You decide to sit next to red. After opening your lunch box, you decide to...'),
					('You decide to sit next to orange. After opening your lunch box, you decide to...'),
					('You decide to sit next to blue. After opening your lunch box, you decide to...'),
					('You sit with your new friend, black. After opening your lunch box, you decide to...'),
					('You sit with your new friend, green. After opening your lunch box, you decide to...'),
					('You sit with your new friend, pink. After opening your lunch box, you decide to...'),
					('As you sit silently, red steals your cookie and you finish the rest of your lonely lunch in silence.'),
					('Red punches you in the face for stealing a sip of red\'s drink. Consequently red gets in trouble, and you finish the rest of your lunch in silence.'),
					('You have made a new friend! You have an awesome first lunch with red.'),
					('Blue turns to you and asks \'What are you doing here?\'. You respond by...'),
					('You just left Blue, where will you sit next?'),
					('Blue sits there and ignores you.'),
					('You have made a new friend! You have an awesome first lunch with blue.'),
					('After you steal a sip from blue, he doesn\'t notice and you feel guilty.'),
					('You have made a new friend! You have an awesome first lunch with orange.'),
					('Orange tells you that if you give him a cookie, he\'ll be your friend.'),
					('You sit silenly next to orange for the rest of lunch.'),
					('After you steal a sip of orange\'s drink, he catches you and tell you to give him a cookie or he\'ll tell the teacher'),
					('(END) Orange tells the teacher and you\'re in trouble and you get suspended'),
					('Orange hits you for lying and he gets in trouble.'),
					('You and your friend sit awkwardly in silence.'),
					('Green takes the cookie and offers you candy in return.'),
					('Pink takes the cookie and glorifies in his awesomeness.'),
					('Black ignores the offer.'),
					('Green catches you stealing a sip, but forgives you and gives you the entire drink in return'),
					('Pink catches you stealing a sip and begins crying.'),
					('Black see you taking a sip, but does nothing.'),
					('It is recess time, but it is raining heavily so you and your classmates are playing indoors; who do you play next to?'),
					('You sit down next to red and play with your toy, and red really likes your toy and asks to play with it.'),
					('You sit down next to pink and play with your toy, and pink really likes your toy and just takes it to play with it.'),
					('You sit down next to green and play with your toy, and green starts to play with you by sharing his toys.'),
					('You gained a new friend! You have a great time playing with your toy with red.'),
					('Red really wanted your toy and because you didn\'t share, he gets mad and breaks your toy.'),
					('Pink gets in trouble for stealing your toy. You stand up and decide to sit next to?'),
					('Pink is impressed with your bravery for standing up for yourself, You gained a new friend!'),
					('Pink revels in his power over others, You sort of gain a new friend!'),
					('Green catches you stealing his toy, but he doesn\'t care and rather gives you his toy.'),
					('You gained a new friend! You have a great time playing with your toy with green.'),
					('You go around and decide to sit next to?'),
					('Red gets in trouble and you get up and decide to sit next to?'),
					('Red enjoys a good fight and you guys have a lot of fun roughing it up. You gained a new friend!'),
					('Red thinks you\'re a loser and gets up and leaves, and you\'re alone, crying...'),
					('You\'re in middle school, and it\'s midterms week. You realize your math test is tomorrow. You decide to:'),
					('You pick up the phone and decide to call'),
					('You go to bed and at the test the next day you:'),
					('You study really hard, but the next day you look at the test and dont understand anything, you:'),
					('Black knows his math, and helps you study,you get an A'),
					('You and blue study together and you both get an B'),
					('Orange doesn\'t seem to know anything and you end up helping him study, he gets an A and you get a C'),
					('You cheat off of who\'s test?'),
					('(END) You failed the test'),
					('You get an A on the test through your own efforts and someone asks you to help them for the next test.'),
					('After cheating off of black, you get an A; he knows you copied his answers, but he doesn\'t care'),
					('(END) After cheating off of pink, you get an A; he knows you copied his answers, and he tells on you. You\'re suspended'),
					('After cheating off of red, you get an C; he tried cheating off of you, so both of you got wrong answers.'),
					('You appreciate black and value him as more just just a tool.'),
					('You\'re just using black.'),
					('You\'re mad at blue because you didn\'t get an A, so you never study with blue again.'),
					('You and blue both celebrate because you guys got B\'s!!!'),
					('The teacher doesn\'t believe orange cheated'),
					('You and orange get in a fist fight'),
					('You forget about the incident'),
					('Orange decides to celebrate the end of midterms and throws a party, inviting the whole school including you. You decide to:'),
					('Orange decides to celebrate the end of midterms and throws a party, inviting the whole school including you, although with a sinister smile. You decide to:'),
					('You walk into the house, and go to:'),
					('pink decides to challenges blue, who is weak, to arm wrestling, you:'),
					('You do nothing but watch on as blue gets humiliated. Then you decide to:'),
					('You and pink have a good laugh as blue loses terribly, you gain a friend! You then decide:'),
					('(BLUE) You slam pink into the ground, and saves blue from humiliation; you guys end up being best friends.'),
					('(BLUE) You and blue end up having a good time at the party and become best friends.'),
					('(PINK) After congratulating pink, you guys hang out and start talking about how awesome each other is.'),
					('(ALONE) You didn\'t really feel like doing anything, and nothing really interests you, so you end up alone.'),
					('(PINK) You and pink have a good time and start talking about how awesome you guys are.'),
					('You decide pink is boring, so you leave and:'),
					('You walk over to orange just as red is trying to pick a fight with orange'),
					('(RED) You help red by punching orange in the face, and you and red leave the party to have fun elsewhere'),
					('(ORANGE) You help orange by telling red to cool it, and orange appreciates your help and you guys have a good time'),
					('(ALONE) You watched as the two fight it out and afterward you have no one to talk to'),
					('Red is drunk and offers you a beer:'),
					('(RED) You and red get really drunk and have lots of laughs, and meet up every weekend to get drunk'),
					('Red asks you to go to a room upstairs, you:'),
					('After leaving red, you decide to:'),
					('(RED) You didn\'t want to drink in front of others but you end up taking the beer, and you guys get chummy'),
					('After leaving red, you decide to:'),
					('You walk over to green while he\'s telling a story and he\'s about to reach the punchline and you:'),
					('(GREEN) You and green continue laughing and you guys have a good time'),
					('Green looks a bit disconcerted and orange sticks up for green, you decide to:'),
					('you leave green and decide to:'),
					('(GREEN) (ORANGE) You, green, and orange have a good time at the party.'),
					('After you decide to not be at the party, black calls and invites you to go to a haunted house. You decide to'),
					('(ALONE) You stay home halloween and do nothing special.'),
					('You arrive at the haunted house. Some people ditched the party to join you. Black asks who wants to go in with him. You:'),
					('You walk inside, following black, go up the stairs into some creepy attic, where black lights a cigarette and he offers you one you:'),
					('(BLACK) You and black hit it off and smoke together for the rest of the year'),
					('(ALONE) You decide to leave.'),
					('Blue goes in. You hear a scream. You:'),
					('(BLUE) Blue had seen a rat. You comfort blue and have a lot of fun.'),
					('(ALONE) Black comes out laughing at you, while holding a recording of a scream. You leave.'),
					('Red comes up to you and tell you that its a prank, and brings you to the party. You decide to:'),
					('You follow everyone in. You see everyone smoking and they ask you if you want to join. You:'),
					('You leave and sneak into the party. You decide to:'),
					('(BLACK) Black is impressed with you, and you guys have a lot of fun.'),
					('As you arrive at the party, orange gets a bunch of his friends to throw you into the pool. You decide to:'),
					('You and Orange have a good laugh and turn the party into a pool party. You hang out with:'),
					('Blue stands up for you. You decide to:'),
					('You start talking to Orange and you choose to talk about:'),
					('As you guys talk about the test, tension builds and you decide to:'),
					('(ORANGE) You find that you and orange have a lot in common, and become best friends and forget the past.'),
					('Orange gets bored and leaves, so you go toward:'),
					('You walk over to green and he is completely drunk and puking, so you:'),
					('(ALONE) You feel that no one is fun to talk to so you leave.'),
					('(GREEN) He quickly recovers the next day and you guys are really good friends.'),
					('(BLUE) Blue helps you out the water and you guys leave the party and chill.'),
					('(ALONE) Blue gives you a look and walks away, and you leave the party soaking wet, only to return home to solitude.')";
	$result = mysql_query($SQL_STRING, $link)
		or trigger_error('Could not insert values: ' . mysql_error());
}

function db_insert_choices(){
	$db_info = $GLOBALS['db'];
	$link = db_default_connection();
	mysql_select_db($db_info['db_name'], $link);
	mysql_query("TRUNCATE TABLE $db_info[choice_table]");
	$SQL_STRING = "INSERT INTO `$db_info[choice_table]` (`text`, `character`, `distance`, `size`) VALUES
					('Black', '0', '0', '0'),
					('Green', '0', '0', '0'),
					('Pink', '0', '0', '0'),
					('Do nothing', '0', '0', '0'),
					('Introduce yourself', '0', '0', '0'),
					('Make fun of black\'s face', '0', '0', '0'),
					('Introducing yourself as well', '3', '1', '1'),
					('Doing nothing', '0', '0', '0'),
					('Make fun of green\'s face', '3', '-1', '-1'),
					('Doing nothing', '0', '0', '0'),
					('Making fun of pink\'s face', '6', '-1', '-1'),
					('Introducing yourself', '6', '1', '1'),
					('Red', '0', '0', '0'),
					('Orange', '0', '0', '0'),
					('Blue', '0', '0', '0'),
					('Black', '1', '1', '0'),
					('Green', '3', '1', '0'),
					('Pink', '6', '1', '0'),
					('Sit and eat your lunch silently', '0', '0', '0'),
					('Offer red a cookie', '4', '1', '1'),
					('Steal a sip from red\'s drink', '4', '-1', '-1'),
					('Sit and eat your lunch silently', '0', '0', '0'),
					('Offer orange a cookie', '5', '1', '1'),
					('Steal a sip from orange\'s drink', '5', '-1', '-1'),
					('Sit and eat your lunch silently', '0', '0', '0'),
					('Offer blue a cookie', '2', '1', '1'),
					('Steal a sip from blue\'s drink', '2', '0', '-1'),
					('Sit silently', '0', '0', '0'),
					('Offer black a cookie', '1', '1', '1'),
					('Steal a sip from black\'s drink', '1', '-1', '-1'),
					('Offer green a cookie', '3', '1', '1'),
					('Steal a sip from green\'s drink', '3', '0', '-1'),
					('Offer pink a cookie', '6', '0', '1'),
					('Steal a sip from pink\'s drink', '6', '-1', '-1'),
					('leave blue to himself', '2', '-1', '0'),
					('sit silently and eat your lunch', '0', '0', '0'),
					('hide and be lonely', '0', '0', '0'),
					('you give orange the cookie', '5', '1', '1'),
					('you don\'t give orange the cookie', '5', '-1', '-1'),
					('you give begrudgingly give orange the cookie', '5', '1', '1'),
					('you don\'t give orange the cookie', '5', '-1', '-1'),
					('You lie and tell the teacher that orange tried to steal your cookie', '5', '-1', '-1'),
					('play next to red', '0', '0', '0'),
					('play next to pink', '0', '0', '0'),
					('play next to green', '0', '0', '0'),
					('share with red', '4', '1', '1'),
					('don\'t share with red', '4', '-1', '-1'),
					('you tell on pink', '6', '-1', '-1'),
					('you take pink\'s toy', '6', '1', '1'),
					('you let pink play with your toy', '6', '1', '1'),
					('steal green\'s toy', '3', '1', '-1'),
					('play with green', '3', '1', '1'),
					('you leave', '0', '0', '0'),
					('You tell on red', '4', '-1', '-1'),
					('You start fighting with red', '4', '1', '1'),
					('You cry', '0', '0', '0'),
					('call someone to study', '0', '0', '0'),
					('forget it, math is too hard', '0', '0', '0'),
					('study by yourself', '0', '0', '0'),
					('Call black', '1', '1', '0'),
					('Call blue', '2', '1', '0'),
					('Call orange', '5', '1', '0'),
					('cheat', '0', '0', '0'),
					('sleep', '0', '0', '0'),
					('guess', '0', '0', '0'),
					('try harder', '0', '0', '0'),
					('Thank black for his help', '1', '1', '1'),
					('Ignore thereafter', '1', '1', '-1'),
					('You wanted an A, not B!', '2', '-1', '-1'),
					('HIGH FIVE!', '2', '1', '1'),
					('lie to teacher and say orange cheated', '5', '-1', '-1'),
					('punch orange', '5', '-1', '-1'),
					('move on', '0', '0', '0'),
					('cheat off of black', '0', '0', '0'),
					('cheat off of pink', '0', '0', '0'),
					('cheat off of red', '0', '0', '0'),
					('you decide to go', '0', '0', '0'),
					('you begrudgingly decide to go', '0', '0', '0'),
					('you decide to not go', '0', '0', '0'),
					('pink', '0', '0', '0'),
					('do nothing', '0', '0', '0'),
					('cheer pink on.', '6', '1', '1'),
					('take blue\'s place', '2', '1', '1'),
					('feel bad for blue and decide to comfort him', '2', '1', '1'),
					('laugh at blue for being a loser and congratulate pink', '6', '1', '1'),
					('say nothing', '0', '0', '0'),
					('keep talking to pink', '6', '1', '1'),
					('you get bored of pink', '6', '-1', '0'),
					('you leave the party', '0', '0', '0'),
					('go to orange', '0', '0', '0'),
					('go to red', '0', '0', '0'),
					('go to green', '0', '0', '0'),
					('5#-1#-1 help red', '4', '1', '1'),
					('4#-1#-1 help orange', '5', '1', '1'),
					('do nothing but watch', '0', '0', '0'),
					('chug it', '4', '1', '1'),
					('decline and just chat', '0', '0', '0'),
					('leave red to his drunkeness', '4', '-1', '0'),
					('go wih red to upstairs', '4', '1', '1'),
					('tell him to go away', '4', '-1', '-1'),
					('go to orange', '0', '0', '0'),
					('go to green', '0', '0', '0'),
					('leave the party', '0', '0', '0'),
					('let him tell it because you think its good', '3', '1', '1'),
					('interrupt', '3', '-1', '-1'),
					('listen and say it\'s stupid', '3', '-1', '-1'),
					('apologize to green', '3', '1', '1'),
					('leave and back down', '0', '0', '0'),
					('Don\'t go', '1', '-1', '-1'),
					('Go', '1', '1', '1'),
					('Go with black', '1', '1', '1'),
					('volunteer someone else', '0', '0', '0'),
					('stay quiet', '0', '0', '0'),
					('you smoke it', '1', '1', '1'),
					('you say no', '1', '-1', '-1'),
					('run inside', '2', '1', '1'),
					('run away', '0', '0', '0'),
					('freeze in fear', '0', '0', '0'),
					('leave', '0', '0', '0'),
					('join in', '1', '1', '1'),
					('leave the party', '5', '-1', '-1'),
					('pull orange into the pool with you', '5', '1', '1'),
					('do nothing', '5', '-1', '-1'),
					('orange', '0', '0', '0'),
					('red', '0', '0', '0'),
					('pink', '0', '0', '0'),
					('the test', '5', '-1', '-1'),
					('something in common', '5', '1', '1'),
					('make small talk', '0', '0', '0'),
					('leave orange', '5', '-1', '-1'),
					('go toward green', '0', '0', '0'),
					('get disgusted and leave', '3', '-1', '-1'),
					('help him by getting him water', '3', '1', '1'),
					('call for help', '3', '1', '1'),
					('accept blue\'s help', '2', '1', '1'),
					('decline his help', '2', '-1', '-1')";
	
	$result = mysql_query($SQL_STRING, $link)
		or trigger_error('Could not insert values: ' . mysql_error());
	
	
}
?>