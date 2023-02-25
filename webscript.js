

// const textInput = document.querySelector(".textInput");
// const label = document.querySelector(".textInput + label");

// textInput.addEventListener("input", function() {
//     if (this.value.length > 0) {
//         label.classList.add("has-text");
//     } else {
//         label.classList.remove("has-text");
//     }
// });
    // function textAreaAdjust(element) {
    //     element.style.height = '0';
    //     element.style.height = element.scrollHeight + 'px';
    // removed since too buggy
    // }


        // survey open logic

        const footer = document.querySelector("footer");
        const main = document.getElementById("main");
        
        const handleResize = () => {
          if (window.innerHeight > parseInt(window.getComputedStyle(main).height) + footer.offsetHeight) {
            footer.style.position = "fixed"
            footer.style.width = "calc(100% - 60px)"
          } else {
            footer.style.position = "relative"
            footer.style.width  ="100%"
            
          }
        };
        
        window.addEventListener("resize", handleResize);
        handleResize();
        var sussy = document.getElementsByClassName("textIput")
    function addClass() { 
    var sassy = document.getElementById("message")
    var element = document.getElementsByClassName("elementMain");
    for(let i = 0; i < element.length; i += 1) {
        element.item(i).classList.add("elementMainExtended");
        sassy.style.height = '300px';
        
        }}
        function removeClass() { 
            var sassy = document.getElementById("message")
            var element = document.getElementsByClassName("elementMain");
            for(let i = 0; i < element.length; i += 1) {
                element.item(i).classList.remove("elementMainExtended");
                sassy.style.height = '60px';
                for (let index = 0; index < sussy.length; index++) {
                  sussy[index].value = ''
              }
                }}

        // navbar logic
        var buttons = document.querySelectorAll("button");

        buttons.forEach((button) => {
        button.addEventListener("click", () => {
            var currentState = button.getAttribute("data-state");

            if (!currentState || currentState === "closed") {
            button.setAttribute("data-state", "opened");
            button.setAttribute("aria-expanded", "true");
            } else {
            button.setAttribute("data-state", "closed");
            button.setAttribute("aria-expanded", "false");
            }
        });
        });


        var startTimes = [8.5, 9.4167, 10.4167, 11.4167, 12.5, 13.4167, 14.3333, 15.1667, 15.917,0];
        var endTimes = [9.25, 10.1667, 11.1667, 12.1667, 13.25 , 14.1667, 15.0833, 15.9167, 32.5,8.5];

        function updateProgressBar() {
        var currentTime = new Date();
        var currentSecond = currentTime.getSeconds();
        var currentHour = currentTime.getHours();
        var currentMinute = currentTime.getMinutes();
        var currentTimeInHours = currentHour + currentMinute / 60;
        


        for (let i = 0; i < startTimes.length; i++) {
            
            if (currentTimeInHours >= startTimes[i] && currentTimeInHours < endTimes[i]) {
            // time interval is in progress sine this is within a defined time interval
            var duration = endTimes[i] - startTimes[i];
            var timePassed = currentTimeInHours - startTimes[i];
            var percentage = (timePassed / duration) * 100;
            let remainder = Math.round((duration-timePassed)*60)
            if (i+1==10) {
                duration = endTimes[i-1] - startTimes[i-1]
                timePassed = currentTimeInHours + 24-startTimes[i-1]
                remainder = Math.round((duration-timePassed)*60 )
                percentage = (timePassed / duration) * 100 ;
                
                
                
            }
            
            updateProgressBarColor('green');
            updateProgressBarWidth(percentage,currentSecond,duration);
            updateCurrentInterval(i + 1 + " Урок"); 
            updateRemained(remainder)
            return;
            } else if (currentTimeInHours >= endTimes[i] && currentTimeInHours < startTimes[i + 1]) {
            var duration = startTimes[i + 1] - endTimes[i];
            var timePassed = currentTimeInHours - endTimes[i];
            var percentage = (timePassed / duration) * 100;
            let remainder = Math.round((duration-timePassed)*60) 
            // console.log(remainder)
            //break in progress since this is in between a defined time interval
            // console.log("BREAK LOOP ")
            updateProgressBarColor('orange');
            updateProgressBarWidth(percentage,currentSecond,duration);
            updateCurrentInterval('Перемена'); // update current interval
            updateRemained(remainder)
            return;
             }// else if (currentTimeInHours >= 0 && currentTimeInHours <= 8.5) 
        }
        }
        function updateProgressBarColor(color) {
        // code to update progress bar color goes here
        document.getElementById('lessonTimeContainer').style.setProperty('--before-background-color', color);
        }
        function updateProgressBarWidth(percentage,seconds,dura) {
        // code to update progress bar width goes here

        document.getElementById('lessonTimeContainer').style.setProperty('--before-width', percentage + "%");
        
        
        }
        
        

        function updateCurrentInterval(interval) {
        // code to update current interval goes here
            



            if ( interval == "10 Урок" || interval == "9 Урок"){
                interval = "Свободное Время"

            }
            document.getElementById('lesson').innerText = interval;
        }
        function updateRemained(remainder) {
            document.getElementById('remaining').innerText ="Осталось: " + remainder + " Минут";
        }

        setInterval(updateProgressBar, 1000); // update progress bar every second


        // let newsAmount = document.querySelectorAll(".newsElement").length;
        // let newsArray = document.querySelectorAll(".newsElement")
                
        // for (let i = 0 ; i < newsAmount; i++) {
        //   newsArray[i].style.backgroundImage = `url('https://source.unsplash.com/random/1300x2000/?school')`
        // }
        var keys = {37: 1, 38: 1, 39: 1, 40: 1};
        function preventDefault(e) {
            e.preventDefault();
          }
          function preventDefaultForScrollKeys(e) {
            if (keys[e.keyCode]) {
              preventDefault(e);
              return false;
            }
          }
          // modern Chrome requires { passive: false } when adding event
          var supportsPassive = false;
          try {
            window.addEventListener("test", null, Object.defineProperty({}, 'passive', {
              get: function () { supportsPassive = true; } 
            }));
          } catch(e) {}
          var wheelOpt = supportsPassive ? { passive: false } : false;
          var wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';
          // call this to Disable
          function disableScroll() {
            window.addEventListener('DOMMouseScroll', preventDefault, false); // older FF
            window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
            window.addEventListener('touchmove', preventDefault, wheelOpt); // mobile
            window.addEventListener('keydown', preventDefaultForScrollKeys, false);
          }
          // call this to Enable
          function enableScroll() {
            window.removeEventListener('DOMMouseScroll', preventDefault, false);
            window.removeEventListener(wheelEvent, preventDefault, wheelOpt); 
            window.removeEventListener('touchmove', preventDefault, wheelOpt);
            window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
          }                
          function decimalToTime(decimal) {
            let hour = Math.floor(decimal);
            let minute = Math.round((decimal % 1) * 60);
            if (hour < 10) {
                hour = "0" + hour;
            }
            if (minute < 10) {
                minute = "0" + minute;
            }
            return hour + ":" + minute;
        }
        

        var menuButton = document.getElementById("hamburgerbutton");
        var navMenu = document.getElementById("nav-menu");
        var thing = false
        menuButton.addEventListener("click", function(){
            if (thing == false) {
                navMenu.classList.add("nav-menu")
                thing = true
                navMenu.classList.remove("hidething")
            }


        }) 
        

        // handle menu open and close
        menuButton.addEventListener("click", function() {
        navMenu.classList.toggle("show");});


        function sendEmail() {
          // Get form values
          var message = document.getElementById("message").value;
          var email = document.getElementById("email").value;
        
          // Check if message and email are not empty
          if (message.trim() !== "" && email.trim() !== "") {
            // Construct email body
            var body = "Message: " + message + "\n\n" + "Email: " + email;
        
            // Send email using mailto link
            var mailtoLink = "mailto:1409support@gmail.com?subject=New message&body=" + encodeURIComponent(body);
            window.location.href = mailtoLink;
        
            // Clear form inputs
            clearInputs();
          } else {
            alert("Введине е-mail и сообщение.");
          }
        }
        
        function clearInputs() {
          document.getElementById("message").value = "";
          document.getElementById("email").value = "";
        }
        





        
