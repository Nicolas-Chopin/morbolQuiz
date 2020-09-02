let app = {

    aTeamScore: {},

    apiBaseURL: 'http://127.0.0.1:8001/',

    init: function() {
        console.log('init');

        let url = new URL(document.URL);
        let id = url.pathname.split('/')[2];

        let aScoreFetched = document.getElementById("a-score").innerHTML;
        
        // on cible
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