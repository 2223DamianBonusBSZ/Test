<!DOCTYPE html>
<html lang="de">

<head>
    <title>Startseite Sportverein</title>

    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <link href="styles.css" type="text/css" rel="stylesheet">     
  
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#news">News</a></li>
            <li><a href="#contact">Contact</a></li>
            <li style="float:right"><a class="active" href="#about">Login</a></li>
        </ul>
    </nav>

    <header>
        <?php

            //https://php-de.github.io/jumpto/datetime/

            $now      = new DateTime();
            $refDate  = new DateTime('2021-11-01');
            $format = 'seit %y Jahren %m Monaten und %d Tagen.';
            $period = $now->diff($refDate)->format($format);
            ?>
        <div>
            <img class="Bild" widght="200" height="100" src="LOGO.jpg" alt="logo">
        </div>
        <h1>TV 1996 BFSISport</h1>
        <p>Wir bringen Menschen in Bewegung seit <?php echo $period ?> </p>        
    
        <div class ="clear"></div>
    </header>        
        
    <div class="contentLeft">   
        <!-- leeres Element, wird auf dieser Seite nicht benötigt -->        
    </div>

    <div class="contentCenter">
        
        <h1 class="text1">Kursanmeldung für Nichtmitglieder</h1><br>
        <?php 
        if (isset($_POST["senden"])) {
            FormularVerarbeitung();
            
        }
        else {
        FormularAusfühlen();

        }
        ?>
        <?php  
        function FormularAusfühlen()
        {
       
        ?>
        <p>Bitte Füllen Sie die nachfolgenden Eingabefelder aus:</p><br>                
        <form class="myForm" action="Formularkomplett.php" method="post">              
            <fieldset>
                <legend>Anrede</legend>
                <label> <input type="radio" name="anrede" checked="true" required value="Frau"> Frau </label>
                <label> <input type="radio" name="anrede" required value="Herr"> Herr </label>
                <label> <input type="radio" name="anrede" required value="ohne"> ohne Anrede </label>
            </fieldset>

            <label for="vorname">Vorname * </label>
            <input type="text" name="vorname" required>

            <label for="nachname">Nachname * </label>
            <input type="text" name="nachname" required>
            
            <label for="telefon">Telefon *</label>
            <input type="tel" name="telefon" required pattern="^[+]?[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$">

            <label for="email">Email * </label>
            <input type="email" name="email" required >   
            
            <label for="geburtsdatum">Geburtsdatum * </label>
            <input type="date" name="geb" required>

            <fieldset>
                <legend>Bevorzugte Tage</legend>
                <label> <input type="checkbox" name="montag" value="Montag"> Montag </label>
                <label> <input type="checkbox" name="dienstag" value="Dienstag"> Dienstag </label>
                <label> <input type="checkbox" name="mittwoch" value="Mittwoch"> Mittwoch </label>
                <label> <input type="checkbox" name="donnerstag" value="Donnerstag"> Donnerstag </label>
                <label> <input type="checkbox" name="freitag" value="Freitag"> Freitag </label>
                <label> <input type="checkbox" name="samstag" value="Samstag"> Samstag </label>
            </fieldset>            

            <label for="kursart">Kursart * </label>
            <select name="kursart">
            <?php 
        
            $Kursart = file("Kursarten.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ;
        
            for($i=0;$i < count($Kursart); $i++)
            {
             echo "<option value='".$Kursart[$i]."'>".$Kursart[$i]."</option>";
            }
            ?>                                             
            </select>

            <label for="memo">Nachricht</label>
            <textarea name="memo" maxlength="500"></textarea>            
            <p>* Pflichtfelder</p> 
            <input type="submit" value="Abschicken" name="senden"/>
            <input type="reset" value="Zurücksetzen" name="reset"/>     


        </form> 
        <?php 
        }    
        ?>   
    </div>

    <div class="contentRight">
            <?php

        function FormularVerarbeitung()
        {


            
            
            $Anrede = htmlspecialchars($_POST["anrede"]);

            isset($_POST["vorname"]) && is_string($_POST["vorname"])
                ?  $Vorname = htmlspecialchars($_POST["vorname"]): $Vorname="";

            isset($_POST["nachname"]) && is_string($_POST["nachname"])
             ?  $Nachname = htmlspecialchars($_POST["nachname"]): $Nachname="";
            
             isset($_POST["telefon"]) && is_int($_POST["telefon"])
              ? $Tel = htmlspecialchars($_POST["telefon"]): $Telefon="";
            
            isset($_POST["geb"]) && is_int($_POST["geb"])
              ? $Geb = htmlspecialchars($_POST["geb"]): $Geb="";
            
            isset($_POST["email"]) && is_string($_POST["email"])
             ? $Email = htmlspecialchars($_POST["email"]): $Email="";
            
            isset($_POST["kursart"]) && is_string($_POST["email"])
             ? $kursart = htmlspecialchars($_POST["kursart"]): $kursart="";

            $TelefonValidation = "/^\\+?[1-9][0-9]{7,14}$/";
            preg_match($TelefonValidation, $Telefon);
            
            echo "<h1>Herzlichen Glückwünsch $Anrede $Nachname!  </h1>";
            echo "<h2>Sie haben Kurs $kursart gewählt</h2>";
            echo "<br>";

            $montag = " ";
            $dienstag = " ";
            $mittwoch = " ";
            $donnerstag = " ";
            $freitag = " ";
            $samstag = " ";

            $Daten=fopen("daten.csv", "a");
                if (!$Daten) 
                {
                    echo "Könnte nicht erstellt werden.";
                    exit;
                }
                else 
                {
                    if (isset($_POST["montag"])) {
                        $montag = "Montag";                
                    }
                    if (isset($_POST["dienstag"])) 
                    {
                        $dienstag = "dienstag";                
                    }
                    if (isset($_POST["mittwoch"])) 
                    {
                    $mittwoch= $_POST['mittwoch'];                
                    }
                    if (isset($_POST["donnerstag"])) 
                    {
                        $donnerstag=$_POST['donnerstag'];                
                    }
                    if (isset($_POST["freitag"])) 
                    {
                    $freitag= $_POST['freitag'];                
                    }
                    if (isset($_POST["samstag"])) 
                    {
                        $samstag	=$_POST['samstag'];                
                    }
                    
                

                fputs($Daten, $Anrede.";".$Vorname.";".$Nachname.";"
                .$Email.";" .$Telefon.";".$Geb.";"
                .$montag.";".$dienstag.";".$mittwoch.";".$donnerstag.";".$freitag.";".$samstag.";"
                .$kursart.";\n");

                echo "Ihre Eingaben wurden gespeichert."; 
                }
                fclose($Daten);
        }
        ?>
    
    </div> 
    
    <footer>
        Der Sportverein der Berufsfachschule für technische Assistenten für Informatik in Roth
    </footer>      

</body>
</html>