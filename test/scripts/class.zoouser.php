<?php
class USERZOO
{
    private $db;
    
    function __construct($DB_con)
    {
        $this->db=$DB_con;
    }
    
    public function login($uname,$upass)
    {
        try
        {
        $result=$this->db->prepare("SELECT * FROM WebUsers WHERE UserName=:uname LIMIT 1");
        $result->execute(array(':uname'=>$uname));
        $userRow=$result->fetch(PDO::FETCH_ASSOC);
        $hashpass=password_hash($userRow['Password'],PASSWORD_DEFAULT);
        if($result->rowCount()>0)
        {
            if(password_verify($upass,$hashpass))
            {
                $_SESSION['user_session']=$userRow[UserID];
                return true;
            }
            else
            {
                return false;
            }
        }
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
        
    }
    
    public function isLoggedin()
    {
        if(isset($_SESSION['user_session']))
        {
            return true;
        }
    }
    public function redirect($url,$errorMsg)
    {
        if($url=='error.php'){
            header("Location: $url?error=$errorMsg");
        }
        else
        {
        header("Location: $url");
        }
    }
    
    public function logout()
    {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
    }
    
    public function fillDropDown($table)
    {
        $sql="Select column_name from information_schema.columns where table_name='$table';";
        $querystmt=$this->db->prepare($sql);
        $querystmt->execute();
        echo "<form>";
		echo "<select name = 'soption'>";
        while($row=$querystmt->fetchObject()) {
            
            echo "<option value = '$row->column_name'>$row->column_name</option>";
        }
    	echo "</select>";
    	echo "<input type='search' name='searchVal' placeholder='Enter Value to Search'>";
		echo "<button type='submit' type='submit' name='submit' value='search'>Search</button>";
    	echo "</form>";
    }
    
    //this will autopopulate navigation bar based on Security Level
    public function showMenu($level)
    {
        $user_id = $_SESSION['user_session'];
        $result=$this->db->prepare("SELECT * FROM WebUsers WHERE UserID=:uid LIMIT 1");
        $result->execute(array(':uid'=>$user_id));
        $userRow=$result->fetchObject();;
        $userLevel=$userRow->UserTypeID;
        
        $sql="Select * from Menu Where menuSecurity<=$userLevel order by menuParent,menuSort ASC";
        $querystmt=$this->db->prepare($sql);
        $querystmt->execute();
        
        while($row=$querystmt->fetchObject())
        {
            if($row->menuParent==0)
            {
                $menu[$row->menuPage]['text']=$row->menutext;
                $menu[$row->menuPage]['link']=$row->menuLink;
            }
            else
            {
                $sub[$row->menuPage]['parent']=$row->menuParent;
                $sub[$row->menuPage]['text']=$row->menutext;
                $sub[$row->menuPage]['link']=$row->menuLink;
                if(empty($menu[$row->menuParent]['count']))
                {
                    $menu[$row->menuParent]['count']=0;
                }
                $menu[$row->menuParent]['count']++;
            }
        }
        
        if(!empty($menu))
        {
            echo "<div id='navmenu'>";
            echo "<ul id='nav'>";
            
            foreach($menu as $page=>$link)
            {
                $name=$link['text'];
                $linkUrl=$link['link'];
                if($name=='Home'|| $name=='Logout')
                {
                    echo "<li><a href='$linkUrl'>$name</a>";
                }
                else 
                {
                    echo "<li><a>$name</a>";
                }
                if($link['count']>0)
                {
                    echo "<ul>";
                    foreach ($sub as $lnk) 
                    {
                        if($page==$lnk['parent'])
                        {
                            $subname=$lnk['text'];
                            $sublink=$lnk['link'];
                            echo "<li><a href='$sublink'>$subname</a></li>";
                        }
                        
                        
                    }
                    echo "</ul>";
                    
                }
                echo "</li>";
                
            }
            echo "</ul>";
            echo "</div>";
            echo "<br/>";
        }
    }
}
?>