<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta name="viewport" content="width=device-width initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="mainstyle.css" rel="stylesheet" >
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&display=swap" rel="stylesheet">
<link href="https://fonts.cdnfonts.com/css/proxima-nova-2" rel="stylesheet">
<link rel="icon" href="chatbot.png">
<title>MY1409</title>


    </head>
    <body>
        <div id="main">
        <div class="navbarCont"style="left: 200px;">
        <a href="index.html" style="height: 52px;"><div class="logo"></div></a>

        <button id="hamburgerbutton" class="hamburgerbutton" aria-controls="primary-navigation" aria-expanded="false" aria-label="Toggle navigation" >
            <svg class="hamburger" viewBox = "0 0 100 100" width="40" height="50">
                <rect class="line first" x="10" y="25px" width="80" height="10" rx="5" fill="#6d6dd6"></rect>
                <rect class="line second" x="10" y="45px" width="80" height="10" rx="5" fill="#6d6dd6"></rect>
                <rect class="line third" x="10" y="65px" width="80" height="10" rx="5" fill="#6d6dd6"></rect>

            </svg> 
        </button>
        <div id="nav-menu" class="hidething">
            <hr>
            <a href="#">Бот</a>
            <hr>
            <a href="#">О нас</a>
            <hr>
            <a href="#">Контакты</a>
            <hr>
        </div>
    </div>
       
        <div class="elementMainExtended" style="display:none ;"></div>       

        
        <div class="elementMain">
            
            <h3 id="promptQuestion">Знаете, как сделать школу лучше? <br>- Напишите нам!</h3>


            <form>
                <div class="formField">
                    <!-- onkeyup="textAreaAdjust(this)" -->
                    <textarea class="textInput" type="text" id="message" cols="30" rows="10" placeholder=" " onclick="addClass()"></textarea>
                    <label for="message">Сообщение</label>
                    
                </div>
                <div class="formField">
                    
                    <input class="textInput" type="text" id="email" placeholder=" ">
                    <label for="email">Е-Mail</label>
                    
                </div>
                <div class="buttoncontainer">
                <button class="surveyButton" onclick="removeClass()" type="button">
                    Отправить! 
                </button>
                <button class="surveyButton" onclick="removeClass()" type="button">
                    Отменить 
                </button>
                </div>

            </form>

              
            
        </div>
        
        <div class="newsSection">
            <p class="newsCaption">Последние события:</p>
                    <!-- THIS IS THE CAROSEL -->
                <div class="newsCaro">

                </div>
                <!-- END OF CARO -->
            
        </div>
        <div class="scheduleSection">
            <div id="lessonTimeContainer">
                <div id="lessonAndSched">
                <p id="lesson"></p>
                <p id="sched"></p>  
                </div>
                <div id="remainingCont">
                <!-- <p id="time" onload="currentTime()"></p> -->
                <p id="remaining"></p> 
                </div>
            </div>
        </div>
        <div>
            <div class="chatbotcaption">
            <img src="chatbot.png" style="width: 30px;height: 30px;"> <p class="newsCaption">Чат Бот</p>
            </div>
            <br>
            <div class="chipscontainer">
             <a href="https://vk.com/im?sel=-210064026">📕 Подобрать олимпиаду</a>
            </div>
            <div class="chipscontainer">
            <a href="https://vk.com/im?sel=-210064026">🥤 В кулере нет стаканчиков</a>
            </div>
            <div class="chipscontainer">
            <a href="https://vk.com/im?sel=-210064026">🔑 Создать аккаунт</a>
            </div>
            <div class="chipscontainer">
            <a href="https://vk.com/im?sel=-210064026">✉️ Еще...</a>
            </div>

        </div>
</div>
        <footer>
        <div id="footer-cont1">
          <img src="hui.png">

            <div id="footer-textcont1">
                <h1>В Моменте</h1>
                <h2>ул. Авиаконструктора Микояна, дом 2, Москва, 125167</h2>
                <h2></h2>
                <h2></h2>
            </div>
        </div>
        <div id="footer-socials">
        <a href="">
            <img src="telegram.png" alt="telegram" width="50" height="50">
        </a>
        <a href="">
            <img src="VK.png" alt="vk" width="50" height="50">
        </a>

        </div>
        </footer>
        <script src="webscript.js">
                
         </script>
    </body>
</html>