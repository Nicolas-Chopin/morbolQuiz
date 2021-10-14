let app = {

    apiBaseURL: new URL(document.URL).origin+'/',

    init: function() {
        //console.log('init');

        let url = new URL(document.URL);
        let id = url.pathname.split('/')[2];
        let isSum = url.pathname.split('/')[3];

        //--------------------------------------------------------------------
        // Plus, Minus & Reset methods for teams' scores
        //--------------------------------------------------------------------
        // fetching current scores
        let aScoreFetched = document.getElementById("a-score").innerHTML;
        let bScoreFetched = document.getElementById("b-score").innerHTML;
        // target + event resolve for + point to A team
        let plusA = document.getElementById("plus-a-team");
        plusA.addEventListener("click", function () {
          let fetchOptions = {
          method: 'POST',
          mode: 'cors',
          cache: 'no-cache'
          };
          if (isSum == 'test-four') {
            fetch(app.apiBaseURL + 'api/session/'+id+'/plusthreea', fetchOptions)
            .then(document.getElementById("a-score").innerHTML = (parseInt(aScoreFetched) + 3))
            .then(aScoreFetched = document.getElementById("a-score").innerHTML);
            
          } else {
            fetch(app.apiBaseURL + 'api/session/'+id+'/plusonea', fetchOptions)
            .then(document.getElementById("a-score").innerHTML = ++aScoreFetched);
          } 
        },);
        // target + event resolve for + point to B team
        let plusB = document.getElementById("plus-b-team");
        plusB.addEventListener("click", function () {
          let fetchOptions = {
          method: 'POST',
          mode: 'cors',
          cache: 'no-cache'
          };
          if (isSum == 'test-four') {
            fetch(app.apiBaseURL + 'api/session/'+id+'/plusthreeb', fetchOptions)
            .then(document.getElementById("b-score").innerHTML = (parseInt(bScoreFetched) + 3))
            .then(bScoreFetched = document.getElementById("b-score").innerHTML);
            
          } else {
            fetch(app.apiBaseURL + 'api/session/'+id+'/plusoneb', fetchOptions)
            .then(document.getElementById("b-score").innerHTML = ++bScoreFetched);
          }
        },);
        // target + event resolve for - point to A team
        let minusA = document.getElementById("minus-a-team");
        minusA.addEventListener("click", function () {
          let fetchOptions = {
          method: 'POST',
          mode: 'cors',
          cache: 'no-cache'
          };
          if (isSum == 'test-four') {
            fetch(app.apiBaseURL + 'api/session/'+id+'/minusthreea', fetchOptions)
            .then(document.getElementById("a-score").innerHTML = (parseInt(aScoreFetched) - 3))
            .then(aScoreFetched = document.getElementById("a-score").innerHTML);
            
          } else {
            fetch(app.apiBaseURL + 'api/session/'+id+'/minusonea', fetchOptions)
            .then(document.getElementById("a-score").innerHTML = --aScoreFetched);
          }
        },);
        // target + event resolve for - point to B team
        let minusB = document.getElementById("minus-b-team");
        minusB.addEventListener("click", function () {
          let fetchOptions = {
          method: 'POST',
          mode: 'cors',
          cache: 'no-cache'
          };
          if (isSum == 'test-four') {
            fetch(app.apiBaseURL + 'api/session/'+id+'/minusthreeb', fetchOptions)
            .then(document.getElementById("b-score").innerHTML = (parseInt(bScoreFetched) - 3))
            .then(bScoreFetched = document.getElementById("b-score").innerHTML);
            
          } else {
            fetch(app.apiBaseURL + 'api/session/'+id+'/minusoneb', fetchOptions)
            .then(document.getElementById("b-score").innerHTML = --bScoreFetched);
          }
        },);
        // target + event reset teams' score
        if (isSum == null) {
          // target + event reset A team's score
          let resetA = document.getElementById("reset-a-team");
          resetA.addEventListener("click", function () {
            let fetchOptions = {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache'
            };
            fetch(app.apiBaseURL + 'api/session/'+id+'/reseta', fetchOptions)
            .then(document.getElementById("a-score").innerHTML = 0)
            .then(aScoreFetched = 0);
          },);
          // target + event reset B team's score
          let resetB = document.getElementById("reset-b-team");
          resetB.addEventListener("click", function () {
            let fetchOptions = {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache'
            };
            fetch(app.apiBaseURL + 'api/session/'+id+'/resetb', fetchOptions)
            .then(document.getElementById("b-score").innerHTML = 0)
            .then(bScoreFetched = 0);
          },);
        }
        // target + event resolve for answers' visibility at click
        // Same with keybind 1, 2, 3, 4
        let answerTrigger = document.querySelectorAll(".answer-letter");
        answerTrigger.forEach(element => {
          element.addEventListener("click", function () {
            element.firstElementChild.classList.remove("hidden")
          })
        });
        document.addEventListener('keydown', function (event) {
          if (event.key === '1') {
            answerTrigger[0].firstElementChild.classList.remove("hidden")
          }
        });
        document.addEventListener('keydown', function (event) {
          if (event.key === '2') {
            answerTrigger[1].firstElementChild.classList.remove("hidden")
          }
        });
        document.addEventListener('keydown', function (event) {
          if (event.key === '3') {
            answerTrigger[2].firstElementChild.classList.remove("hidden")
          }
        });
        document.addEventListener('keydown', function (event) {
          if (event.key === '4') {
            answerTrigger[3].firstElementChild.classList.remove("hidden")
          }
        });
        // target + event resolve for is answer correct at click
        // Same with Enter and 0 
        let trigger = document.getElementById("soluce");
        trigger.addEventListener("click", function() {
          answerTrigger.forEach(element => {
            element.firstElementChild.classList.remove("text-ivory")
          })
        });
        document.addEventListener('keydown', function (event) {
          if (event.key === 'Enter') {
            answerTrigger.forEach(element => {
              element.firstElementChild.classList.remove("text-ivory")
            })
          } else if (event.key === '0') {
            answerTrigger.forEach(element => {
              element.firstElementChild.classList.remove("text-ivory")
            })
          }
        });           
    },    

    //--------------------------------------------------------------------
    // Tool method
    //--------------------------------------------------------------------
    convertJSONtoJS: function (response) {
        console.log(response);
        if (!response.ok) {
        throw "Erreur";
        }
        return response.json();
    },
};

document.addEventListener('DOMContentLoaded', app.init);