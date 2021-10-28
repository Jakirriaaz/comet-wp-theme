<?php 
/*
Template Name: Php Learn

*/

//Calculator making

class Calculation{
    function add($x, $y){
        echo "summitions = ".($x+$y)."<br>";
    }
    function sub($x, $y){
        echo "Substraction = ".($x-$y)."<br>";
    }
    function mul($x, $y){
        echo "Multiple = ".($x*$y)."<br>";
    }
    function divi($x, $y){
        echo "Divition = ".($x/$y)."<br>";
    }
}

?>

<form action="" method="POST">
    <table>
        <tr>
            <td>Enter the First value: </td>
            <td><input type="number" name="num1"></td>
        </tr>
        <tr>
            <td>Enter the Second value: </td>
            <td><input type="number" name="num2"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="calculation" value="Calculator"></td>
        </tr>
    </table>
</form>

<?php 
    if(isset($_POST['calculation'])){
        $firstone = $_POST['num1'];
        $secondone = $_POST['num2'];

        if(empty($firstone) or empty($secondone)){
            echo "<span style='color:red;'>Field must not be empty</span>";
        }

        $cal = new Calculation;
        $cal->add($firstone, $secondone);
        $cal->sub($firstone, $secondone);
        $cal->mul($firstone, $secondone);
        $cal->divi($firstone, $secondone);
    }


//__Constructor

    class Classname{
        public $name;
        public $age;

        public function __construct($name, $age)
        {
            $this->name = $name;
            $this->age = $age;
        }

        public function personDetails(){
            echo "Person name is {$this->name} and Age is {$this->age}<br>";
        }
    }

    $oneperson = new Classname("Hasan", "36");
    $oneperson->personDetails();


//__Destructor

class Nameclass{
    public $name;
    public $age;
    public $id;

    public function setId($id){
        $this->id = $id;
    }

    public function __destruct(){
        mysql_closs();
    }
}

// $kichu = new Nameclass("H Batpar", "20");
// $kichu->setId(20);
// unset($kichu);

class userData{
    public $user;
    public $userId;
    const NAME = "Sohidullah";
    public static $age="30";

    public function __construct($user, $userId){
        $this->user = $user;
        $this->userId = $userId;

        echo "User name is {$this->user} and ID is {$this->userId}<br>";
    }

    public function __destruct(){
        unset($this->user);
        unset($this->userId);
    }

    public static function display(){
        echo "Full name is ".UserData::NAME."<br>";
        echo "Age is :".self::$age."<br>";
    }
}

$user  = "Jaak";
$id    = "25";

$use = new userData($user, $id);
UserData::display();


//Interface
interface amarschoole{
    public function myschool();
}

interface tomarschoole{
    public function yourschool();
}

interface taharschool{
    public function herschool();
}

class Teacher implements amarschoole, tomarschoole, taharschool{
    public function __construct(){
        $this->myschool();
        $this->yourschool();
        $this->herschool();
    }

    public function myschool(){
        echo "I am a school teacher.<br>";
    }

    public function yourschool(){
        echo "I'm your school teacher.<br>";
    }

    public function herschool(){
        echo "I'm her school teacher.<br>";
    }
}

$teach = new Teacher();


//Abstract Class

abstract class Student{

    public $name; 
    public $age;

    public function details(){
        echo $this->name." is ".$this->age." years old <br>";

    }
    abstract public function school();
}

class Boy extends Student{
    public function describe(){
        return parent::details()."And I am a hight school student.<br>";

    }

    public function school(){
        return "I like to watch the thiller movie <br>";
    }
}

$s = new boy();
$s->name = "Jamal";
$s->age = "30";
echo $s->describe();
echo $s->school();


//Magic methods
/*
__get($property)
__set($property, $value)
__call($method, $arg_array)
*/

class Program{
    public function describe(){
        echo "I am a student<br>";
    }
}

$st = new Program();
$st->describe();