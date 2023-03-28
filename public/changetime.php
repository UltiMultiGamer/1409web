


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="forms.css">
    <link href="https://fonts.cdnfonts.com/css/proxima-nova-2" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<div class="bgimg"></div>
<div class="form-wrapper">
        <h2>Изменить Время</h2>
        <p>Создайте новые интервалы</p>
        <button id="add-interval" class="button">Добавить</button>
        <form onsubmit="getData()" method="post">
            <p>
            
            <div class="form-group align-horiz">
                <input type="button" class="button" value="Отправить" onclick="getData()">
                <input type="reset" class="button" value="Сбросить">
            </div>
            <p><a href="login.php">Вернуться</a></p>
        </form>
    </div>
</body>
<script>
    // Get the form and the add interval button
const form = document.querySelector('form');
const addIntervalBtn = document.getElementById('add-interval');

// Count how many intervals have been added so far
let intervalCount = 0;

// Add a new interval to the form when the button is clicked
addIntervalBtn.addEventListener('click', function() {
  // Increment the interval count
  intervalCount++;

  // Create the new lesson element
  const newLesson = document.createElement('div');
  newLesson.classList.add('form-group');
  newLesson.classList.add('doubleform');
  newLesson.innerHTML = `
    <div class="something">
    <input class="text-input" type="text" name="lesson-name" placeholder=" "></input>
    <label>Событие ${intervalCount} Название</label>
    </div>
    </div class="something">
    <div class="align-horiz">
    <div class="something">
    <input type="time" name="lesson-start" class="text-input time" value="" placeholder=" ">
    <label>Событие ${intervalCount} Начало</label>
    </div>
    <div class="something">
    <input type="time" name="lesson-end" class="text-input time" value="" placeholder=" ">
    <label>Событие ${intervalCount} Конец</label>
    </div>
    </div>
    <div>
    <label for="eventtype"></label>
    <select name="eventtype-${intervalCount}" class="eventtype">
    <option>Урок</option>
    <option>Каникулы</option>
    <option>Событие</option>
    <option>Событие с трансляцией</option>
    </select>
    </div>
    <div class="something">
    <input type="text" class="link-to-stream text-input" name="lesson-stream" placeholder=" "></input>
    <label for="lesson-stream" class="stream-link">Ссылка</label>
    </div>
  `;

  // Add the new lesson element to the form
  const lessonContainer = document.querySelector('.form-wrapper');
  form.insertBefore(newLesson, form.children[intervalCount-1]);

  var selectElements = document.querySelectorAll('.eventtype');
var divElements = document.querySelectorAll('.link-to-stream');
var divLabels = document.querySelectorAll(".stream-link");

for (let i = 0; i < selectElements.length; i++) {
  selectElements[i].addEventListener('change', (event) => {
    const selectedValue = event.target.value;

    if (selectedValue === 'Событие с трансляцией') {

        divElements[i].style.display = "block"
        divLabels[i].style.display ="block"
    } 
  });
}

});


function getData() {
    
    // Get the form and all the relevant inputs
    const form = document.querySelector('form');
    console.log(form)
    let eventName = document.querySelectorAll('input[name="lesson-name"]')
    let startInputs = document.querySelectorAll('input[name="lesson-start"]');
    let endInputs = document.querySelectorAll('input[name="lesson-end"]');
    let eventTypeSelects = document.querySelectorAll('select[name^="eventtype-"]');
    let streamLinkInputs = document.querySelectorAll('input[name="lesson-stream"]');
    
    let EventNames = [];
    let TimeStartTimes = [];
    let TimeEndTimes = [];
    let TimeEventType = [];
    let EventLink = [];
    

    EventNames.length = 0;
    TimeStartTimes.length = 0;
    TimeEndTimes.length = 0;
    TimeEventType.length = 0;
    EventLink.length = 0;
    
      for (let i = 0; i < startInputs.length; i++) {
        EventNames.push(eventName[i].value);
        TimeStartTimes.push(startInputs[i].value);
        TimeEndTimes.push(endInputs[i].value);
        TimeEventType.push(eventTypeSelects[i].value);
        EventLink.push(streamLinkInputs[i].value);
      }
      


      function convertToDecimal(TimeStartTimes, TimeEndTimes) {
        let decimalStartTimes = [];
        let decimalEndTimes = [];

        for (let i = 0; i < TimeStartTimes.length; i++) {
          let startHour = parseInt(TimeStartTimes[i].split(":")[0]);
          let startMinute = parseInt(TimeStartTimes[i].split(":")[1]);
          let endHour = parseInt(TimeEndTimes[i].split(":")[0]);
          let endMinute = parseInt(TimeEndTimes[i].split(":")[1]);

          let decimalStart = startHour + (startMinute / 60);
          let decimalEnd = endHour + (endMinute / 60);

          decimalStartTimes.push(decimalStart.toFixed(4));
          decimalEndTimes.push(decimalEnd.toFixed(4));
        }

        return [decimalStartTimes, decimalEndTimes];
      }
  

      [TimeStartTimes,TimeEndTimes] = convertToDecimal(TimeStartTimes, TimeEndTimes)



      console.log('EventNames:', EventNames);
      console.log('TimeStartTimes:', TimeStartTimes);
      console.log('TimeEndTimes:', TimeEndTimes);
      console.log('TimeEventType:', TimeEventType);
      console.log('EventLink:', EventLink);
    
// assuming you have the arrays defined in JavaScript
var data = {
    eventNames: EventNames,
    startTimes: TimeStartTimes,
    endTimes: TimeEndTimes,
    eventTypes: TimeEventType,
    eventLinks: EventLink
};
var xhr = new XMLHttpRequest();
xhr.open('POST', 'appendtimes.php', true);
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.onload = function () {
    if (xhr.status === 200) {
        console.log(xhr.responseText);
    } else {
        console.log('Error: ' + xhr.status);
    }
};

xhr.send(JSON.stringify(data));





}



</script>
</html>