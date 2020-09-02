let app = {

    aTeamScore: {},

    apiBaseURL: 'http://127.0.0.1:8001/',

    init: function() {
        console.log('init');

        let url = new URL(document.URL);
        let id = url.pathname.split('/')[2];

        
        
        //--------------------------------------------------------------------
        // Plus & Minus methods for teams' scores
        //--------------------------------------------------------------------
        // fetching current scores
        let aScoreFetched = document.getElementById("a-score").innerHTML;
        let bScoreFetched = document.getElementById("b-score").innerHTML;
        // target + event resolve for +1 point to A team
        let plusA = document.getElementById("plus-a-team");
        plusA.addEventListener("click", function () {
          let fetchOptions = {
          method: 'POST',
          mode: 'cors',
          cache: 'no-cache'
          };
          fetch(app.apiBaseURL + 'api/session/'+id+'/plusonea', fetchOptions)
          .then(app.convertJSONtoJS)
          .then(document.getElementById("a-score").innerHTML = ++aScoreFetched);
        },);
        // target + event resolve for +1 point to B team
        let plusB = document.getElementById("plus-b-team");
        plusB.addEventListener("click", function () {
          let fetchOptions = {
          method: 'POST',
          mode: 'cors',
          cache: 'no-cache'
          };
          fetch(app.apiBaseURL + 'api/session/'+id+'/plusoneb', fetchOptions)
          .then(app.convertJSONtoJS)
          .then(document.getElementById("b-score").innerHTML = ++bScoreFetched);
        },);
        // target + event resolve for -1 point to A team
        let minusA = document.getElementById("minus-a-team");
        minusA.addEventListener("click", function () {
          let fetchOptions = {
          method: 'POST',
          mode: 'cors',
          cache: 'no-cache'
          };
          fetch(app.apiBaseURL + 'api/session/'+id+'/minusonea', fetchOptions)
          .then(app.convertJSONtoJS)
          .then(document.getElementById("a-score").innerHTML = --aScoreFetched);
        },);
        // target + event resolve for -1 point to B team
        let minusB = document.getElementById("minus-b-team");
        minusB.addEventListener("click", function () {
          let fetchOptions = {
          method: 'POST',
          mode: 'cors',
          cache: 'no-cache'
          };
          fetch(app.apiBaseURL + 'api/session/'+id+'/minusoneb', fetchOptions)
          .then(app.convertJSONtoJS)
          .then(document.getElementById("b-score").innerHTML = --bScoreFetched);
        },);
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