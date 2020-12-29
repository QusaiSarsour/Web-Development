<?php
    session_start();
        //$_SESSION['history']=array();
        //$_SESSION['history'][]=$history_txt;

       // print_r($_SESSION['history_array']); 
        if(!isset($_SESSION['history']))
        {
            $_SESSION['history'] = array();
        }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Calculator</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.0.0/mdb.min.css">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.css" integrity="sha512-sjJT//vtBb7ohxokcp2yH2FHfU+9B1OQFVJzZ1JwIfe3oVHTEqk/67CYSihA0CoiRPdWNfUm5xHyaeg8wRUQuA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.lite.css" integrity="sha512-OnEMk7iRVTkcpxwEr7xrrrTfdlQyl02JWRSFnq4DOJ3K+Fv4Q112yMNkgPV0/q9dlEYMZVRQg20vTL+bXfc1Dg==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.lite.min.css" integrity="sha512-rtKpq+tUiLpzSJ9MWw/nbRZjsGzTqFoh+cyzF8IVSAEO5TeQLCXCfELo/a1dLy/4Zc9SWyZ6YAPvrD+E4n4fZQ==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" integrity="sha512-RO38pBRxYH3SoOprtPTD86JFOclM51/XTIdEPh5j8sj4tp8jmQIx26twG52UaLi//hQldfrh7e51WzP9wuP32Q==" crossorigin="anonymous" />    
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">      
<!--    <link rel="stylesheet" href="./assets/stylesheets/bootstrap.min.css" />
-->    <link rel="stylesheet" href="./assets/stylesheets/bootstrap-responsive.min.css" />
  </head>
  <body>
<?php
    $current_txt ="";
    $input ="";
    $result ="";  
    $result_ae="";  
    $history_txt="";
      
    if(isset($_POST['input-data']))
    {
        $current_txt = $_POST['input-data'];
    }
    if(isset($_POST['operation']))
    {
        $input=$_POST['operation'];
    }
    if(isset($_POST['number']))
    {
        $input=$_POST['number'];
    }      
    if(isset($_POST['equal']))
    {         
        /*
        error_reporting(-1);
        function my_error_handler($errno, $message)
        { 
            throw new ErrorException($message);
            throw new \Exception('Exception message');

        }
        set_error_handler('my_error_handler');
        /*
        function Exceptions_error_handler()
        {
            throw new ErrorException("error");
        }
        set_error_handler('Exceptions_error_handler'); */       
        try {
            $result =  eval('return ' . $current_txt . ';');
            $history_txt = $current_txt ." = " . eval('return ' . $current_txt . ';'); 
            array_push($_SESSION['history'],$history_txt);        
            $current_txt .= "";
        } catch(DivisionByZeroError $e){
            echo "<script> alert('You Cannot Divide by Zero') </script> ";
        } catch(ErrorException $e) {
            echo "<script> alert('Please Make Sure that the Inputs is Formatted and Entered Correctly') </script>";
        } catch(Exception $e) {
            echo "<script> alert('Please Make Sure that the Inputs is Formatted and Entered Correctly') </script>";
        }        
        /*
        try{
            eval("\$result = $expresion;");
        }
        catch(Exception $e){
            $result = 0;
        }
        echo "The result is: $result";
        */

        /*$result_ae="end";*/
    }
    else 
    {
        $current_txt .=$input;
    }
    if ($input == "all-clear") {
        $current_txt = "";
    }
    if($input == "Clear-History")  
    {
        $current_txt = "";
        unset($_SESSION['history']);
    }
    if($input == "Delete-History") 
    {
        $current_txt = "";        
        if(isset($_SESSION['history']))
        {
            array_pop($_SESSION['history']);
        }        
    }
    if ($input == "CE")
    {
        $input=$_POST['input-data'];
        $current_txt =substr($input, 0, -1);
    }
    if($input=="plusms")
    {
        $input=$_POST['input-data'];
        $new=substr($input, 1);
        if(strpos($input,'-',0))
        {
            $current_txt = "+".$new;            
        }
        else
        {
            $current_txt = "-".$new;        
        }
        /*
        if($_POST['current_txt'] == ("-".$_POST['input-data']))
        {
            $new2=substr_replace($current_txt,$new,1,1);
            $current_txt = "+".$new2;

        }else{
            $new2=substr_replace($current_txt,$new,1,1);
            $current_txt = "-".$new2;
        }*/
    }    
    if($result_ae == "end")
    {
        $current_txt ="";
    }               
?>
<div class="pos-f-t">

  <nav class="navbar navbar-dark bg-dark" style="padding: 4px;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <button class="btn btn-md btn-outline-success " onclick="location.href='./index.php'" type="button" style="width: 20%">Calculator
      </button>
  </nav>
</div>      

    <div class="container">
       <form method="post" id="calculator">

      <div class="hero-unit mb3" id="calculator-wrapper" style="padding: 20px;">
        <div class="row-fluid">
          <div class="span8">
            <div>
<!--                  <label for="input-data" class="form-label">The Input</label>
-->                <input name="input-data" type="text" class="form-control" id="input-data" placeholder="Enter Your Data" value="<?php echo $current_txt;?>"></div>
          </div>
          <div class="span1" style="text-align: center;">
            <div class="visible-print-inline-block">
              =
            </div>
          </div>
          <div class="span3">
            <div id="calculator-result"  class="form-control"><?php echo $result;?></div>
          </div>
        </div>          
<!--        <div class="row-fluid">
          <div class="span8">
            <div id="calculator-screen" class="uneditable-input">
                <label for="input-data">The Input</label>
                <input type="text" name="input-data" class="calculator-screen z-depth-1" id="input-data" value="<?php //echo $current_txt;?>"/>
              </div>
          </div>
          <div class="span4">
            <div id="calculator-result" class="uneditable-input">
              <label for="result-data">The Result</label>
                <input name="result-data" type="text" class="calculator-screen z-depth-1" id="result-data" value="<?php //echo $result;?>" readonly="readonly"> 
              </div>
          </div>
        </div>-->

      </div>

      <div class="row-fluid">
        <div class="span6 well hero-unit" style="padding: 20px;">
          <div id="calc-board" class="d-table-row">
            <div class="row-fluid">              
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="log" value="log(">Log</button>
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="log10" value="log10(">Log10</button>                
                <button name="operation" type="submit" class="btn btn-info waves-effect " id="sqrt" value="sqrt(">&#8730;</button>
                <button name="operation" type="submit" class="btn btn-info btn-info waves-effect" id="exp" value=" **2 ">x2</button>
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="expy" value=" ** ">x^y</button>                
              </div>
            <div class="row-fluid">
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="sin" value="sin(">Sin</button>
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="cos" value="cos(">Cos</button>  
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="tan" value="tan(">Tan</button>
                <button name="operation" type="submit" class="btn btn-info waves-effect"  id="(" value="(">(</button>
                <button name="operation" type="submit" class="btn btn-info waves-effect"  id=")" value=")">)</button>                                
            </div>
            <div class="row-fluid">
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="add" value=" + ">+</button>
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="sub" value=" - ">-</button>
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="mult" value=" * ">&times;</button>
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="div" value=" / ">&divide;</button>
                <button name="operation" type="submit" class="btn btn-info modulus waves-effect" id=" % " value="%">%</button>
            </div>
            <div class="row-fluid">
                <button name="number" type="submit" class="btn btn-light waves-effect" id="7" value="7">7</button>
                <button name="number" type="submit" class="btn btn-light waves-effect" id="8" value="8">8</button>
                <button name="number" type="submit" class="btn btn-light waves-effect" id="9" value="9">9</button>
                <button name="operation" type="submit" class="btn waves-effect btn-dark" id="CE" value="CE">&crarr;</button>  
                <button name="operation" type="submit" class="all-clear function btn btn-danger" value="all-clear">All Clear</button>                
            </div>
            <div class="row-fluid">
                <button name="number" value="4" class="btn btn-light waves-effect" type="submit" id="4">4</button>
                <button name="number" type="submit" class="btn btn-light waves-effect" id="5" value="5">5</button>
                <button name="number" type="submit" class="btn btn-light waves-effect" id="6" value="6">6</button>
                <button name="operation" type="submit" class="btn waves-effect btn-dark" id="Delete-History" value="Delete-History">Delete History</button>                
                <button name="operation" type="submit" class="all-clear function btn btn-danger" id="Clear-History" value="Clear-History">Clear History</button>                                
                
            </div>
            <div class="row-fluid">
                <button name="number" type="submit" class="btn btn-light waves-effect" id="1" value="1">1</button>
                <button name="number" type="submit" class="btn btn-light waves-effect" id="2" value="2">2</button>
                <button name="number" type="submit" class="btn btn-light waves-effect" id="3" value="3">3</button>
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="1/X" value=" ** -1">1/X</button>
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="e" value=" M_E ">e</button>
                
            </div>
            <div class="row-fluid">
                <button name="number" type="submit" class="decimal function btn btn-secondary" id="dot" value=".">.</button>                
                <button name="number" type="submit"class="btn btn-light waves-effect" id="0" value="0">0</button>
                <button name="operation" type="submit"class="btn waves-effect btn-warning" id="plusms" value="plusms">&plusmn</button>
                <button name="equal" type="submit" class="equal-sign btn btn-success" id="equal" value="=">=</button>
                <button name="operation" type="submit" class="btn btn-info waves-effect" id="div" value=" pi() ">&#883;</button>
                
            </div>
          </div>
        </div>
        <div class="span6 well hero-unit mb-4">
          <legend><strong>History</strong></legend>
          <div id="calc-panel" class="form-row" >
            <div id="calc-history"  class="col-7">
                <ol class="list-group-item list-group-item-action active">                        
                
                  <table class="table list-group">                       
                    <tr>
                      <th><strong>Last Results</strong></th>
                    </tr>
                    <tr>      
                      <?php 
                            if(isset($_SESSION['history']))
                            {   
                                for($i = 0 ; $i < count($_SESSION['history']) ; $i++)
                                {
                                    for($l = 0 ; $l < count($_SESSION['history']) ; $l++)
                                    {
                                        $j=2;
                                        if($i==$j*$l)
                                        { 
                                            echo "<tr></tr>";
                                        }
                                    }   
                                        echo "<tr><td>";
                                        echo "<ol class='list-group-item list-group-item-action list-group-item-success'>";
                                        echo '<li calss="list-group-item">';                                    
                                        echo $_SESSION['history'][$i];
                                        echo "</li>";     
                                        echo "</ol>";
                                        echo "</td></tr>";
                                    
                                }
                            }
                        ?>
                    </ol>
                    
                        </tr>
              </table>  
            </div>
          </div>
        </div>
</form>

      </div>
    </div>

<?php
    /*$SESSION['veriable'] = 0;
    session_start();*/
   /* if(isset($_POST['result']))
    {    
        $current_txt = $_POST['result'];
    } /*
    if(isset($_POST['operation']))
    {   
        $current_txt = $_POST['operation'];
    }
    if(isset($_POST['number']))
    {
        $current_txt =$_POST['number'];
    }*/

      /*
    else
    {
        $current_txt .= $input;
    }
        echo $current_txt; 
           

/*
    if(isset($_POST['equal']))
    {
        $input="calculate";
    }
    if($input == "calculate")
    {  
        $history = eval('return ' . $current_txt . ';');        
        $current_txt .= "=" . eval('return ' . $current_txt . ';');
        $result = "end";
        echo $result;
    }else{
        $current_txt .= $input;
    }
    if ($input == "clear") {
        $current_txt = "";
    }
    if ($input == "delete") {
        $input=$_POST['result'];
        $current_txt =substr($input, 0, -1); 
    }
    if($result == "end")
    {
        $current_txt="";
    }
        if($_POST['operation']=="all-clear")
        {
            $input = "clear";   
        }   
        if($_POST['operation']=="CE")
        {
            $input = "delete";
        }
/* $equal=$_POST['equal'];
    $result=$_POST['result'];
    $number=$_POST['number'];
    $operation=$_POST['operation'];
    $_SESSION['result'] =$_SESSION['number'].$_SESSION['equal'];
    echo $_SESSION['result'];*/
/*
    if(isset($_POST['result']))
    {
        $current_txt = $_POST['result'];
    }
    if(isset($_POST['number']))
    {
        if($_POST['number']=="0")
        {
            $input="0";
        } 
        if($_POST['number']=="1")
        {
            $input="1";
        } 
        if($_POST['number']=="2")
        {
            $input="2";
        }   
        if($_POST['number']=="3")
        {
            $input="3";
        } 
        if($_POST['number']=="4")
        {
            $input="4";
        } 
        if($_POST['number']=="5")
        {
            $input="5";
        }   
        if($_POST['number']=="6")   
        {
            $input="6";
        } 
        if($_POST['number']=="7")
        {
            $input="7";
        } 
        if($_POST['number']=="8")
        {
            $input="8";
        }
        if($_POST['number']=="9")
        {
            $input="9";
        }  
        if($_POST['number']=="dot")
        {
            $input=".";
        }          
    }
    if(isset($_POST['operation']))
    {
        if($_POST['operation']=="sin")
        {
            $input="sin(";
        } 
        if($_POST['operation']=="cos")
        {
            $input="cos(";
        } 
        if($_POST['operation']=="tan")
        {
            $input="tan(";
        }   
        if($_POST['operation']=="(")
        {
            $input="(";
        } 
        if($_POST['operation']==")")
        {
            $input=")";
        } 
        if($_POST['operation']=="add")
        {
            $input="+";
        }   
        if($_POST['operation']=="sub")
        {
            $input="-";
        } 
        if($_POST['operation']=="mult")
        {
            $input="*";
        } 
        if($_POST['operation']=="div")
        {
            $input="/";
        }
        if($_POST['operation']=="mod")
        {
            $input="%";
        }  
        if($_POST['operation']=="exp")
        {
            $input="**2";
        }   
        if($_POST['operation']=="expy")
        {
            $input="**";
        }
        if($_POST['operation']=="log")
        {
            $input="log(";
        } 
        if($_POST['operation']=="log10")
        {
            $input="log10(";
        }    
        if($_POST['operation']=="sqrt")
        {
            $input="sqrt(";
        }  
        if($_POST['operation']=="all-clear")
        {
            $current_txt="";
        }  
        if($_POST['operation']=="CE")
        {
            $input=$_POST['result'];
            $current_txt =substr($input, 0, -1);            
        }
        if($_POST['operation']=="plusms")
        {
            $input=$_POST['result'];
            $new=substr($input, 1);
            if($_POST['current_txt'] === ("-".$current_txt))
            {
                $current_txt = "+".substr_replace($current_txt,$new,0,1);

            }else{
                $current_txt = "-".substr_replace($current_txt,$new,1,1);
            }
        }            
    }
    if(isset($_POST['equal']))
          {
              $history = eval('return ' . $current_txt . ';');        
              $current_txt .= "=" . eval('return ' . $current_txt . ';');
              $resultequal = "end";
          }else{
              $current_txt .= $input;
          }
              if($resultequal == "end")
              {
                  $current_txt="";
              }    
*/
/*
    if(isset($_POST['result-pro']))
    {    
        $current_txt = $_POST['result-pro'];
    }    

    if(isset($_POST['add']))
    {
        $input= "+";
    }    
    if(isset($_POST['sub']))
    {   
        $input= "-";
    }
    if(isset($_POST['mult']))
    {
        $input= "*";
    }
    if(isset($_POST['div']))
    {
        $input= "/";
    }
    if(isset($_POST['mod']))
    {
        $input= "%";
    }
    if(isset($_POST['exp']))
    {
        $input= "**2";
    }
    if(isset($_POST['expy']))
    {
        $input= "**";
    }
    if(isset($_POST['number1']))
    {   
        $input = "1";
    }
    if(isset($_POST['number2']))
    {
        $input = "2";
    }
    if(isset($_POST['number3']))
    {
        $input = "3";
    }
    if(isset($_POST['number4']))
    {
        $input = "4";
    }
    if(isset($_POST['number5']))
    {
        $input = "5";
    }
    if(isset($_POST['number6']))
    {
        $input = "6";
    }
    if(isset($_POST['number7']))
    {
        $input = "7";
    }
    if(isset($_POST['number8']))
    {
        $input = "8";
    }
    if(isset($_POST['number9']))
    {
        $input = "9";
    }
    if(isset($_POST['number0']))
    {
        $input = "0";
    }
    if(isset($_POST['sqrt']))
    {
        $input = "sqrt";          
    } 
    if(isset($_POST['sin']))
    {
        $input = "sin";          
    } 
    if(isset($_POST['cos']))
    {
        $input = "cos";          
    } 
    if(isset($_POST['tan']))
    {
        $input = "tan";          
    } 
    if(isset($_POST['log']))
    {
        $input = "log";          
    } 
    if(isset($_POST['log10']))
    {
        $input = "log10";          
    } 
    if(isset($_POST['tan']))
    {
        $input = "tan";          
    } 
    if ($input == "sqrt"|| $input =="sin"||$input == "cos"|| $input =="tan" || $input == "log"|| $input =="log10")
    {
        for($i=0 ;$i<=10000000;$i++)
        {
          if ($current_txt == ($i.$input ))
          {
            $current_txt = ($input."(".$i.")"); 
          }
        } 
    }
    if(isset($_POST['dot']))
    {
        $input = ".";
    }
    if(isset($_POST['CE']))
    {
        $input = "delete";   
    }   
    if(isset($_POST['C']))
    {
        $input = "clear";
    }
    if(isset($_POST['equal']))
    {
        $input="calculate";
    }
    if($input == "calculate")
    {  
        $history = eval('return ' . $current_txt . ';');        
        $current_txt .= "=" . eval('return ' . $current_txt . ';');
        $result = "end";
    }else{
        $current_txt .= $input;
    }
    if ($input == "clear") {
        $current_txt = "";
    }
    if ($input == "delete") {
        $input=$_POST['result-pro'];
        $current_txt =substr($input, 0, -1); 
    }
    if($result == "end")
    {
        $current_txt="";
    }
    if(isset($_POST['plusms']))
    {
        /*$input = "plusms";*/ /*
        $input=$_POST['result-pro'];
        $new=substr($input, 1);
        if($_POST['current_txt'] === ("-".$current_txt))
        {
           /* $current_txt = "+".substr($input, 1).$current_txt;*/ /*
            $current_txt = "+".substr_replace($current_txt,$new,0,1);
            
        }else{
            /*$current_txt = "-".substr($input, 1).$current_txt;*/ /*
            $current_txt = "-".substr_replace($current_txt,$new,1,1);
        }
    }*/
?>
      
<footer class="bg-dark text-white text-center text-lg-start footer-copyright page-footer">      
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
		Created with <i class="fa fa-heart"></i> by
		<a target="_blank" href="https://www.facebook.com/Qusai.A.Sarsour/">Qusai Sarsour</a>
		- &copy; Copyright 2020-<?php echo date("Y");?> Qusai Sarsour
  </div>
</footer>      
  </body>    
</html>
