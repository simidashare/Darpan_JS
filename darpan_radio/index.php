<!DOCTYPE html>
<?php
session_start();

require_once "database.php";
 

$username = $password = "";
$username_err = $password_err = $login_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    
    if(empty($username_err) && empty($password_err)){
        
        $sql = "SELECT broadcasterid, userid, broadcastername,visibility, password FROM broadcaster WHERE userid = :username";
        
        if($stmt = $conn->prepare($sql)){
            
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            
            $param_username = trim($_POST["username"]);
            
            
            if($stmt->execute()){
                
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $broadcasterid = $row["broadcasterid"];
                        $broadcastername = $row["broadcastername"];
                        $returned_password = $row["password"];
                        $visibility = $row["visibility"];
                        if($password == $returned_password){
                                                        
                            // if(!isset($_SESSION)) 
                            // { 
                                session_start(); 

                                
                                $_SESSION["loggedin"] = true;
                                $_SESSION["broadcasterid"] = $broadcasterid;
                                $_SESSION["broadcastername"] = $broadcastername;                            
                                $_SESSION["visibility"] = $visibility;    

                                if($_SESSION["visibility"] == "visible"){
                                    header("location:./pages/main.php");
                                    exit;
                                }else{
                                    header("location:./pages/mainViewOnly.php");
                                    exit;
                                }                               
                              
                            // } 
                            
                        } else{
                            
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            unset($stmt);
        }
    }
    
    
    unset($conn);
}
?>


<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Darpan Radio</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
        integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous" />
</head>

<body>
    <!-- Navbar Section -->
    <nav class="navbar">
        <div class="navbar__container">
            <a href="#HOME" id="navbar__logo">
                <img src="./images/DarpanLogo.gif" alt="logo" />
            </a>
            <div class="navbar__toggle" id="mobile-menu">
                <span class="bar"></span> <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar__menu">
                <li class="navbar__item">
                    <a href="#HOME" class="navbar__links" id="home-page">Home</a>
                </li>

                <li class="navbar__item">
                    <div class="dropdown" data-dropdown>
                        <a class="navbar__links link" id="about-page" data-dropdown-button>Navigation</a>
                        <div class="dropdown-menu information-grid">
                            <div>
                                <div class="dropdown-links" data-links>
                                    <a href="#INTRODUCTION" class="link sub-page1" data-link='s0'>introduction</a>
                                    <a href="#HISTORY" class="link sub-page2" data-link='s0'>history</a>
                                    <a href="#STRUCTURE" class="link sub-page3" data-link='s0'>structure</a>
                                    <a href="#OIC" class="link sub-page4" data-link='s8'>overseas citizen of india
                                        cardholder</a>
                                    <a href="#HINDI_FOR_KIDS" class="link sub-page5" data-link='s9'>hindi for kids in
                                        australia</a>
                                    <a href="#INDIAN_DUPPORT_CENTER" class="link sub-page6" data-link='s10'>indian
                                        support center</a>
                                    <a href="#AUSTRALIAN_COUNCIL_OF_HINDU_CLERGY" class="link sub-page7"
                                        data-link='s11'>australian council of hindu clergy</a>
                                    <a href="#USEFUL_LINKS" class="link sub-page8" data-link='s12'>Useful Links</a>
                                </div>
                            </div>
                        </div>
                </li>
                <li class="navbar__btn">
                    <div class="dropdown" data-dropdown>
                        <a class="button link" id="signin" data-dropdown-button>Log in</a>
                        <div class="dropdown-menu">
                            <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                method="post">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password">
                                <button type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <div data-wrapper='s0' class="sections active">
        <div class="hero" id="HOME">
            <div class="hero__bg">
                <video class="hero__bg--video" src="./video/video2.mp4" type="video/mp4" autoplay loop muted></video>
            </div>
            <div class="hero__content">
                <h1 class="hero__heading">Darpan Radio <span>FM 98.5</span></h1>
                <p class="hero__description">Presented by Raj Batra Team</p>
                <button class="main__btn"><a href="#INTRODUCTION">Get started</a></button>
            </div>
        </div>
    </div>

    <!-- Section 1-->
    <div data-wrapper='s0' class="sections active">
        <div class="main" id="INTRODUCTION" data-wrapper-section>
            <div class="main__container">
                <div class="main__img--container">
                    <div class="main__img--card"><img src="./images/svg-1.svg" style="max-height:75%;max-width:95%">
                    </div>
                </div>
                <div class="main__content">
                    <h1>INTRODUCTION</h1>
                    <p>
                        Darpan Hindi Radio Group is a Hindi Language Broadcastng Group of
                        Multi-Cultural Radio Association Ltd (MCRA). MCRA has given an
                        airtime of one hour to the group to broadcast a radio program in
                        Hindi on every Sunday from 10-11 am on MCRA Radio Station - Radio
                        2000 FM 98.5 MHz. The program is run and managed by the financial
                        members of the Darpan Hindi Radio Broadcasting Group All members
                        work on a voluntary basis without receiving any financial benefit.
                        Any funds raised through sponsorship from business enterpreneurs are
                        used to improve the quality and effectiveness of broadcast and for
                        charity purposes such as helping poor and needy children.
                    </p>
                    <button class="main__btn"><a href="#HISTORY">Read More</a></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2-->
    <div data-wrapper='s0' class="sections active">
        <div class="main" id="HISTORY" data-wrapper-section>
            <div class="main__container">
                <div class="main__content">
                    <h1>HISTORY</h1>
                    <p>
                        Darpan Hindi Radio Group was established in 1992 as a Hindi language
                        broadcasting group of MCRA (Mult-Cultural Radio Association). Like
                        Hindi group, there are more than 30 different language groups. MCRA
                        has a license to operate a radio station under the name of Radio
                        2000 FM. All the language groups of MCRA broadcast their programs on
                        this radio station.
                        <br />
                        <br />
                        Under this arrangement Hindi broadcasting group is operating with
                        the help of selfless volunteers and has been providing an excellent
                        community service. No volunteer has ever received any financial
                        payment for their efforts to run the program. From time to time ,
                        some old members had to leave due to their other commitments. New
                        members came and thus the community service project is continuing.
                        <br />
                        <br />
                        Due to some inter-group conflicts, MCRA had to close its operation
                        in 1996. Efforts to revive MCRA started soon under the selfless and
                        able leadership of Mr. Inoke Fotu Hu'akau. Hindi group gave full
                        support to save and revive MCRA.
                        <br />
                        <br />
                        As a result of the tireless efforts of many right thinking and
                        hardworking people, MCRA was revived and resumed its operations in
                        1998. Conveners of all the language groups were asked to assemble
                        their group members and start broadcasting. Hindi group proudly
                        restarted broadcasting of its program on every Sunday from 8am to
                        9am from March 1998.
                        <br />
                        <br />
                        Thus Darpan Hindi Radio program is running smoothly now as a great
                        community service. To bring Darpan to this stage, all members have
                        been working extremely hard on a voluntary basis, overcoming
                        numerous difficulties and adversities.
                    </p>
                    <button class="main__btn"><a href="#STRUCTURE">Read More</a></button>
                </div>
                <div class="main__img--container">
                    <div class="main__img--card">
                        <img src="./images/svg-3.svg" style="max-height:75%">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3-->
    <div data-wrapper='s0' class="sections active">
        <div class="main" id="STRUCTURE" data-wrapper-section>
            <div class="main__container">
                <div class="main__img--container">
                    <div class="main__img--card"><img src="./images/svg-4.svg" style="max-height:75%">
                    </div>
                </div>
                <div class="main__content">
                    <h1>STRUCTURE</h1>
                    <p>
                    <div class="main__content--div">
                        This program is run and managed by the financial members of the Hindi
                        Broadcasting Group of MCRA A financial member is defined as the one who
                        has paid his/her joining fee and the annual membership renewal fee for the
                        current financial year.
                        <br /> <br />
                        All of these members are volunteers and run the radio program without any
                        financial benefit.
                        <br /> <br />
                        The operational structure of the group is as follows: <br />
                        <ul style="list-style: inside; margin-left:1.2rem">
                            <li>General Body</li>
                            <li>Group Convener</li>
                            <li>Executive Committee</li>
                            <li>Broadcasting Delegates</li>
                        </ul>
                        <br /> <br />
                        <h2>General Body </h2>
                        <br />
                        All the financial members of the group form the General Body of the group.
                        They suggest implement and participate in improving the quality of the
                        program. They elect/choose the members of the Executive Committee,
                        consisting of 5 members including Group Convener, Secretary and Treasurer
                        in the AGM (Annual General Meeting) of the group.
                        <br /> <br />
                        <h2>Group Convener</h2>
                        <br />
                        The group has one convener. The convener is chosen from among the current
                        financial members of the group. The convener performs the following
                        functions:
                        <br />
                        <ul style="list-style: inside; margin-left:1.2rem">
                            <li>Co-ordinate activities of the group, including program roster and
                                sponsorship.etc</li>
                            <li>Attend Convenees Meetings conducted by MCRA</li>
                            <li>Executive Committee</li>
                            <li>Convene meetings of the group and exchange information among all
                                group's members via periodical reports</li>
                        </ul>
                        <br /> <br />
                        <h2>Executive Committee</h2>
                        <br />
                        The Executive Committee members look after the operation of the group. It
                        consists of five members elected from among the financial members of the
                        group. They perform various duties such as broadcasting, account keeping,
                        collecting community announcement/s and obtaining sponsorship/s etc. All
                        decisions are taken in consultation with all the Executive Committee
                        members.
                        <br /> <br />
                        <h3>Current Executive Committee is as follows: </h3>
                        <br />
                        <table>
                            <tbody
                                style="display: flex; flex-wrap:nowrap; flex-direction: column;justify-content: space-around; align-items: flex-start">
                                <tr style="display: flex; flex-wrap:nowrap; margin-bottom: 2rem; align-items: center">
                                    <td>Convener: </td>
                                    <td style="margin-left: 1rem">
                                        Dr Pradeep Kumar
                                    </td>
                                </tr>
                                <tr style="display: flex; flex-wrap:nowrap; margin-bottom: 2rem; align-items: center">
                                    <td>Secretary:</td>
                                    <td style="margin-left: 1.2rem">
                                        Shri Sanjay Sharma
                                    </td>
                                </tr>
                                <tr style="display: flex; flex-wrap:nowrap; align-items: center">
                                    <td>Treasurer:</td>
                                    <td style="margin-left: 1.2rem">
                                        Shri Akhil Verma
                                    </td>
                                </tr>
                                <tr style="display: flex; flex-wrap:nowrap; margin-bottom: 2rem; align-items: center">
                                    <td>Member1:</td>
                                    <td style="margin-left: 1.2rem; margin-top: 2rem">
                                        Shri Virendra Sharma (Shri Prem Arora, Chairman, SVHF is looking
                                        after Shri Sharma's portfolio while Shri Sharma is not available)
                                        <br />
                                    </td>
                                </tr>
                                <tr style="display: flex; flex-wrap:nowrap; margin-bottom: 2rem; align-items: center">
                                    <td>Member2:</td>
                                    <td style="margin-left: 1.2rem;">
                                        Shri Ajoy Ghosh
                                    </td>
                                </tr>
                                <tr style="display: flex; flex-wrap:nowrap; align-items: center">
                                    <td>Webmaster: </td>
                                    <td style="margin-left: 1.2rem;">
                                        Shri Raj Batra
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br /> <br />
                        <h2>Group Treasurer</h2>
                        <br />
                        The functions of Group Treasurer are as follows: <br />
                        <ul style="list-style: inside; margin-left:1.2rem">
                            <li>Account keeping</li>
                            <li>Invoicing and issue receipts</li>
                            <li>Receive sponsorship money and deposit into the bank account</li>
                            <li>Organise payments for expenses such as air-time fee to MCRA. </li>
                            <li>Monthly/Quarterly/Annual Account report to members.</li>
                        </ul>
                        <br /> <br />
                        <h2>Group Secretary</h2>
                        <br />
                        The functions of Group Secretary are as follows: <br />
                        <ul style="list-style: inside; margin-left:1.2rem">
                            <li>Maintain membership register</li>
                            <li>Organise meetings</li>
                            <li>Prepare and circulate minutes of the group meetings</li>
                        </ul>
                        <br /> <br />
                        <h2>Broadcasting Team</h2>
                        <br />A broadcasting team is chosen from among the members of the Group.
                        This broadcasting team is responsible for preparing and compering
                        (presenting) the program. The broadcasting team members use a rostering
                        system.
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <!-- Section 4-->
    <!-- Section 5-->
    <!-- Section 6-->
    <!-- Section 7-->
    <!-- Section 8-->
    <div data-wrapper='s8' class="sections">
        <div class="main" id="OIC" data-wrapper-section>
            <div class="main__container">
                <div class="main__content">
                    <h1>OVERSEAS CITIZEN OF INDIA (OCI) CARDHOLDER</h1>
                    <p> Overseas citizen of India card is required to be re-issued each time a new
                        password is issued up to the age of 20 years.
                        <br />
                        <br />
                        Re-issuance of the OCI card is not mandatory each time a new passport is
                        issued between 21 and 50 years of age. However, if the applicant wishes to
                        obtain new set of OCI document, he/she can apply for the same. <br />
                        <br />
                        OCI card is required to be re-issued only once on renewal of passport
                        after completing 50 years of age. <br />
                        <br />
                        If the OCI card is issued at the age of 50 years or later, there is no
                        need for renewal of the OCI card.
                        <br />
                        <br />
                        Applicants may also refer to the following links (including FAQs) for any
                        further clarification on the matter: <br />
                        <br />
                        a. <a href="https://boi.gov.in/content/overseas-citizen-india-oci-cardholder" target="_blank"
                            style="text-decoration: none; color:inherit">https://boi.gov.in/content/overseas-citizen-india-oci-cardholder</a><br />
                        <br />
                        b. <a href="https://mha.gov.in/MHA1/OCI.html" target="_blank"
                            style="text-decoration: none; color:inherit">https://mha.gov.in/MHA1/OCI.html</a>
                    </p>
                </div>
                <div class="main__img--container">
                    <div class="main__img--card"><img src="./images/svg-2.svg" style="max-height:75%;max-width:90%">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 9-->
    <div data-wrapper='s9' class="sections">
        <div class="main" id="HINDI_FOR_KIDS" data-wrapper-section>
            <div class='iframe_container'>
                <iframe src="https://www.ipetitions.com/petition/hindi-for-kids-in-australia"></iframe>
            </div>
        </div>
    </div>

    <!-- Section 10-->
    <div data-wrapper='s10' class="sections">
        <div class="main" id="INDIAN_DUPPORT_CENTER" data-wrapper-section>
            <div class='iframe_container'>
                <iframe src="https://indiansupportcenter.org.au/"></iframe>
            </div>
        </div>
    </div>

    <!-- Section 11-->
    <div data-wrapper='s11' class="sections">
        <div class="main" id="AUSTRALIAN_COUNCIL_OF_HINDU_CLERGY" data-wrapper-section>
            <div class='iframe_container'>
                <iframe src="https://www.australiancouncilofhinduclergy.com/"></iframe>
            </div>
        </div>
    </div>

    <!-- Section 12-->
    <div data-wrapper='s12' class="sections">
        <div class="main" id="USEFUL_LINKS" data-wrapper-section>
            <div class="link__container">
                <div class="link__content">
                    <h1>Useful Links</h1>
                    <div>
                        <ul>
                            <li><a href="http://www.indianconsulatesydney.org/" target="__blank">Indian Consulate</a>
                            </li>
                            <li><a href="http://www.hinducouncil.com.au" target="__blank">Hindu Council</a></li>
                            <li><a href="http://www.mgdistribution.com.au" target="__blank">Movies Theatres</a></li>
                            <li><a href="http://www.akshayapatra.org" target="__blank">Akshaya Patra</a></li>
                            <li><a href="http://www.sewainternational.org.au" target="__blank">Seva International</a>
                            </li>
                            <li><a href="https://www.ekal.org/au" target="__blank">Darpan Ekal Vidyalaya</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer__container">
        <div class="social__media--wrap">
            <p class="website__rights">© Darpan Radio 2021. All rights reserved</p>
        </div>
    </div>

    <script src="app.js" defer type="module"></script>
</body>

</html>
