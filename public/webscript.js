

// const text-input = document.querySelector(".text-input");
// const label = document.querySelector(".text-input + label");

// text-input.addEventListener("input", function() {
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
    var element = document.getElementsByClassName("element-main");
    for(let i = 0; i < element.length; i += 1) {
        element.item(i).classList.add("element-main-extended");
        sassy.style.height = '300px';
        
        }}
        function removeClass() { 
            var sassy = document.getElementById("message")
            var element = document.getElementsByClassName("element-main");
            for(let i = 0; i < element.length; i += 1) {
                element.item(i).classList.remove("element-main-extended");
                sassy.style.height = '60px';
                for (let index = 0; index < sussy.length; index++) {
                  sussy[index].value = ''
              }
                }}


 


        if (document.getElementById('lesson-time-container') != null) {
          
          console.log(startTimes)
          console.log(endTimes)
          console.log(eventTypes)
          console.log(eventLinks)
          console.log(eventNames)
          startTimes = startTimes.map(str => parseFloat(str))
          endTimes = endTimes.map(str => parseFloat(str))
          startTimes.push(0)
          endTimes.push(24+startTimes[0])
          endTimes.push(startTimes[0])
  
          // var startTimes = [8.5, 9.4167, 10.4167, 11.4167, 12.5, 13.4167, 14.3333, 15.1667, 15.917,0];
          // var endTimes = [9.25, 10.1667, 11.1667, 12.1667, 13.25 , 14.1667, 15.0833, 15.9167, 24+startTimes[0],startTimes[0]];
  
          function updateProgressBar() {
            var currentTime = new Date();
            var currentSecond = currentTime.getSeconds();
            var currentHour = currentTime.getHours();
            var currentMinute = currentTime.getMinutes();
            var currentTimeInHours = currentHour + currentMinute / 60;
            for (let i = 0; i < startTimes.length; i++) {  
                if (currentTimeInHours >= startTimes[i] && currentTimeInHours < endTimes[i] ) {
  
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
                var text = ""
                if (eventNames[i]==undefined) {
                  text = "Free Time";
              } else {
                  text = eventNames[i];
              }
                updateLink(eventLinks[i])
                updateProgressBarColor('green');
                updateProgressBarWidth(percentage,currentSecond,duration);
                updateCurrentInterval(text); 
                updateRemained(remainder)
                return;
  
                } else if (currentTimeInHours >= endTimes[i] && currentTimeInHours <= startTimes[i + 1]) {
                  
                var duration = startTimes[i + 1] - endTimes[i];
                var timePassed = currentTimeInHours - endTimes[i];
                var percentage = (timePassed / duration) * 100;
                let remainder = Math.round((duration-timePassed)*60) 
                updateProgressBarColor('orange');
                updateProgressBarWidth(percentage,currentSecond,duration);
                updateCurrentInterval("Перемена"); // update current interval
                updateRemained(remainder)
                return;
                 } else if(i>= eventNames.length) {
                 
                  duration = endTimes[i-1] - startTimes[i-1]
                    timePassed = currentTimeInHours + 24-startTimes[i-1]
                    remainder = Math.round((duration-timePassed)*60 )
                    percentage = (timePassed / duration) * 100 ; 
                    updateProgressBarColor('orange');
                    updateProgressBarWidth(percentage,currentSecond,duration);
                    updateCurrentInterval("Свободное время"); // update current interval
                    updateRemained(remainder)
                 }
            }
            }
            function updateLink(link) {
              if (link != undefined) {
              document.getElementById("linkbtn").style.visibility = "visible"
              document.getElementById("watchstream").href = link
              document.getElementById("watchstream").innerText = "Смотреть"
              }
  
            }
  
            function updateProgressBarColor(color) {
            // code to update progress bar color goes here
            document.getElementById('lesson-time-container').style.setProperty('--before-background-color', color);
            }
            function updateProgressBarWidth(percentage,seconds,dura) {
            // code to update progress bar width goes here
            document.getElementById('lesson-time-container').style.setProperty('--before-width', percentage + "%");
            }
            function updateCurrentInterval(interval) {
            // code to update current interval goes here
  
                document.getElementById('lesson').innerText = interval;
            }
            function updateRemained(remainder) {
                document.getElementById('remaining').innerText ="Осталось: " + remainder + " Минут";
            }
            setInterval(updateProgressBar, 1000); // update progress bar every second      
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
        }
        const hamburgerButton = document.querySelector('#hamburgerbutton');
        const navList = document.querySelector('.nav-list');
        const navListItems = document.querySelectorAll('.nav-list li');
        
        let isOpen = false;
        let isAnimating = false;
        let isAnimatingGlobally = false;
        
        function toggleMenu() {
          if (isAnimating) {
            return; // Don't do anything if animation is still in progress
          }
        
          if (!isOpen) {
            navList.classList.add('show');
            isAnimating = true;
            hamburgerButton.setAttribute("data-state", "opened");
            hamburgerButton.setAttribute("aria-expanded", "true");
            navListItems.forEach((item, index) => {
              setTimeout(() => {
                item.classList.remove('fade-out');
                item.classList.add('fade-in');
                if (index === navListItems.length - 1) {
                  setTimeout(() => {
                    isAnimating = false; // Set animation to complete when the last item has finished animating

                  }, navListItems.length*220); // Wait for 0.5 seconds before allowing another animation
                }
              }, index * 220);
            });
            isOpen = true;
          } else {
            hamburgerButton.setAttribute("data-state", "closed");
            hamburgerButton.setAttribute("aria-expanded", "false");
            navListItems.forEach((item, index) => {
              setTimeout(() => {
                item.classList.remove('fade-in');
                item.classList.add('fade-out')
                if (index === navListItems.length - 1) {
                  setTimeout(() => {
                    isAnimating = false; // Set animation to complete when the last item has finished animating and the menu is hidden
                  }, navListItems.length*220); // Wait for 0.5 seconds before allowing another animation
                }
              }, (navListItems.length - 1 - index) * 220);
            });
            isOpen = false;
            isAnimating = true;
          }
        }
        hamburgerButton.addEventListener('click', toggleMenu);


                
        
        


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
        





        
