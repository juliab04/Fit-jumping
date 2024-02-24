<!DOCTYPE html>
<html>
{{--<meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">--}}
<body>


<form id="regForm" action="note" method="post">
    @csrf
    <h1>Запись:</h1>
    <!-- Одна "вкладка" для каждого шага в форме: -->
    <div class="tab">Ваше имя:
        <p><input placeholder="Имя..." oninput="this.className = ''" name="name"></p>
        <p><input placeholder="Фамилия..." oninput="this.className = ''" name="surname"></p>
    </div>
    <div class="tab">
        <label for="group">Выберите группу:</label>

        <select id="group" name="group_id" required>
            @foreach($groups as $group)
                <option value={{$group->id}}>{{$group->name}}</option>
            @endforeach
        </select><br><br>

    </div>
    <div class="tab">Контактная информация:
        <p><input placeholder="E-mail..." oninput="this.className = ''" name="email"></p>
    </div>

    <div class="tab"> Контактная информация:

        <input type="text" name="phone" id="phoneInput" placeholder="Введите номер телефона">
        <button type="button" id="verifyButton">Подтвердить</button>

        <!-- Форма ввода кода подтверждения будет изначально скрыта -->
        <div id="confirmationForm" style="display: none;">
            <input type="text" name="verificationCode" id="codeInput" placeholder="Введите код подтверждения">
            <button type="button" id="confirmButton">Подтвердить код</button>
        </div>
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>

    <script>
        document.getElementById("verifyButton").addEventListener("click", function(){
            var phone = document.querySelector('#phoneInput').value;
            axios.post('/verify-phone', {
                phone: phone
            })
                .then(function (response) {
                    if(response.data.success) {
                        alert("СМС отправлено");
                        document.getElementById("confirmationForm").style.display = "block"; // Отобразить форму подтверждения
                    } else {
                        alert("Номер телефона недействителен");
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    alert("Произошла ошибка при отправке СМС")
                });
        });

        document.getElementById("confirmButton").addEventListener("click", function(event){
            var code = document.querySelector('#codeInput').value;
            var phone = document.querySelector('#phoneInput').value;
            axios.post('/confirm-phone', {
                phone: phone,
                code: code
            })
                .then(function (response) {
                    if(response.data.success) {
                        alert("Код подтвержден");
                        document.getElementById("nextBtn").disabled = false; // Enable the button
                    } else {
                        alert("Код не подтвержден, пожалуйста, проверьте СМС и введите код снова");
                        event.preventDefault();
                    }
                })
                .catch(function (error) {
                    // обработка ошибок
                    console.log(error);
                    alert("Произошла ошибка при подтверждении кода");
                    event.preventDefault();
                });
        });
    </script>
    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Назад</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Далее</button>
        </div>
    </div>
    <!-- Круги, которые обозначают шаги формы: -->
    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
{{--        <span class="step"></span>--}}
    </div>
</form>

<script>
    var currentTab = 0; // Текущая вкладка будет первой вкладкой (0)
    showTab(currentTab); // Отображение текущей вкладки

    function showTab(n) {
        // Эта функция будет отображать указанную вкладку формы...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        //... и зафиксируйте предыдущие/следующие кнопки:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Отправить";
            document.getElementById("nextBtn").disabled = true; // disable the button initially
        } else {
            document.getElementById("nextBtn").innerHTML = "Далее";
        }
        //... и запустить функцию, которая будет отображать правильный индикатор шага:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // Эта функция определит, какая вкладка будет отображаться
        var x = document.getElementsByClassName("tab");
        // Выйдите из функции, если какое-либо поле в текущей вкладке является недопустимым:
        if (n == 1 && !validateForm()) return false;
        // Скрыть текущую вкладку:
        x[currentTab].style.display = "none";
        // Увеличение или уменьшение текущей вкладки на 1:
        currentTab = currentTab + n;
        // если вы дошли до конца формы...
        if (currentTab >= x.length) {
            // ... форма будет отправлена:
            document.getElementById("regForm").submit();
            return false;
        }
        // В противном случае отобразите правильную вкладку:
        showTab(currentTab);
    }

    function validateForm() {
        // Эта функция занимается проверкой полей формы
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        // Цикл, который проверяет каждое поле ввода на текущей вкладке:
        for (i = 0; i < y.length; i++) {
            // Если поле пусто...
            if (y[i].value == "") {
                // добавьте в поле класс "invalid":
                y[i].className += " invalid";
                // и установите текущий допустимый статус в false
                valid = false;
            }
        }
        // Если действительный статус равен true, отметьте шаг как завершенный и действительный:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // верните действительный статус
    }

    function fixStepIndicator(n) {
        // Эта функция удаляет класс "active" из всех шагов...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... и добавляет класс "active" на текущем шаге:
        x[n].className += " active";
    }
    {{--function updateSpecialists() {--}}
    {{--    let serviceId = document.getElementById("services").value;--}}
    {{--    let specialistServices = {!! json_encode($specialistServices) !!};--}}
    {{--    let specialists = {!! json_encode($specialists) !!};--}}
    {{--    let specialistSelect = document.getElementById("specialist");--}}
    {{--    specialistSelect.innerHTML = "";--}}

    {{--    // Создать и добавить пустой элемент в качестве первого варианта.--}}
    {{--    let defaultOption = document.createElement("option");--}}
    {{--    defaultOption.value = "";--}}
    {{--    defaultOption.text = "Выберите специалиста";--}}
    {{--    specialistSelect.add(defaultOption);--}}

    {{--    for (let i = 0; i < specialistServices.length; i++) {--}}
    {{--        if (specialistServices[i].service_id == serviceId) {--}}
    {{--            let specialistId = specialistServices[i].specialist_id;--}}
    {{--            let specialist = specialists.find(specialist => specialist.id == specialistId);--}}

    {{--            if (specialist) {--}}
    {{--                let option = document.createElement("option");--}}
    {{--                option.value = specialist.id;--}}
    {{--                option.text = specialist.name;--}}
    {{--                option.title = specialist.description;--}}
    {{--                specialistSelect.add(option);--}}
    {{--            }--}}
    {{--        }--}}
    {{--    }--}}
    {{--}--}}
    {{--function updateCalendars() {--}}
    {{--    let serviceId = document.getElementById("services").value;--}}
    {{--    let specialistId = document.getElementById("specialist").value;--}}
    {{--    let specialistServices = {!! json_encode($specialistServices) !!};--}}
    {{--    let calendars = {!! json_encode($calendars) !!};--}}
    {{--    let dateSelect = document.getElementById("date");--}}
    {{--    let timeSelect = document.getElementById("time");--}}

    {{--    dateSelect.innerHTML = "";--}}
    {{--    timeSelect.innerHTML = "";--}}

    {{--    let selectedSpecialistService = specialistServices.find(s => s.specialist_id == specialistId && s.service_id == serviceId);--}}
    {{--    if (!selectedSpecialistService) return;--}}

    {{--    let timeOptionsByDate = {};--}}
    {{--    let addedDates = {};--}}

    {{--    for (let i = 0; i < calendars.length; i++) {--}}
    {{--        let calendar = calendars[i];--}}

    {{--        if (calendar.specialist_service_id == selectedSpecialistService.id) {--}}
    {{--            if (!addedDates[calendar.date]) {--}}
    {{--                let optionDate = document.createElement("option");--}}
    {{--                optionDate.value = calendar.date;--}}
    {{--                optionDate.text = calendar.date;--}}
    {{--                dateSelect.add(optionDate);--}}
    {{--                addedDates[calendar.date] = true;--}}
    {{--            }--}}

    {{--            if (!timeOptionsByDate[calendar.date]) {--}}
    {{--                timeOptionsByDate[calendar.date] = [];--}}
    {{--            }--}}

    {{--            let optionTime = document.createElement("option");--}}
    {{--            optionTime.value = calendar.time;--}}
    {{--            optionTime.text = calendar.time;--}}
    {{--            timeOptionsByDate[calendar.date].push(optionTime);--}}
    {{--        }--}}
    {{--    }--}}

    {{--    dateSelect.addEventListener('change', function () {--}}
    {{--        let selectedDate = this.value;--}}
    {{--        timeSelect.innerHTML = "";--}}

    {{--        if (selectedDate in timeOptionsByDate) {--}}
    {{--            timeOptionsByDate[selectedDate].forEach(function (optionTime) {--}}
    {{--                timeSelect.add(optionTime);--}}
    {{--            });--}}
    {{--        }--}}
    {{--    });--}}

    {{--    // Trigger the change event manually at first to populate the initial time slots--}}
    {{--    let changeEvent = new Event('change');--}}
    {{--    dateSelect.dispatchEvent(changeEvent);--}}
    {{--}--}}




</script>

</body>
<style>
    * {
        box-sizing: border-box;
    }

    body {
        background: url("https://catherineasquithgallery.com/uploads/posts/2021-02/thumbs/1612250804_81-p-svetlo-fioletovii-tsvet-fon-88.jpg") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Droid Serif', serif;
    }

    #regForm {
        background-color: rgba(0, 0, 0, 0.5);
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 70%;
        min-width: 300px;
    }

    h1 {
        text-align: center;
        color: #d3d3d3;
    }

    input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 0;
        border-left: 4px solid;
        border-color: black;
        color: white;
        background: transparent;
    }

    /* Отметьте поля ввода, которые получают ошибку при проверке: */
    input.invalid {
        background-color: #ffdddd;
    }

    /* Скрыть все шаги по умолчанию: */
    .tab {
        display: none;
        color: #d3d3d3;
    }

    button {
        background-color: #4CAF50;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Raleway;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.8;
    }

    #prevBtn {
        background-color: #bbbbbb;
    }

    /* Сделайте круги, которые обозначают шаги формы: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5;
    }

    .step.active {
        opacity: 1;
    }

    /* Отметьте шаги, которые закончены и действительны: */
    .step.finish {
        background-color: #4CAF50;
    }


</style>
</html>
