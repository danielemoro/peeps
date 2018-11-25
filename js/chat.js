$(function() {
  // scroll to the bottom
  $('#chatFlow').scrollTop($('#chatFlow')[0].scrollHeight);

  function moveHighlight(){
    var pos = $("#userchatbox").position();
    $("#highlighttext").css({left: pos.left+5, top: pos.top+10});
  }
  $(window).on('resize', moveHighlight);
  moveHighlight();


  $("#userchatbox").keyup(function() {
    //Get
    var userInput = "  " + $('#userchatbox').val();

    function highlight(rawInput) {
      userInput = rawInput;
      // Apply the highlighting

      // help
      var found = userInput.match(/help/i);
      if(found){
        userInput = userInput.replace(/help/i, "<span|class='help'>help</span>");
        return userInput
      }

      //question
      var found = userInput.match(/[?]$/g);
      if(found){
        return "<span|class='question'>" + userInput + " </span>";
      }

      //contacts
      var numContacts = 0;
      userInput = userInput.replace(/\B\@[\w| ]{3,}/i, function(match, offset, string) {
        numContacts += 1;
        var space = match.lastIndexOf(" ")
        return "<span|class='contact'>" + match.substring(0, space) + "</span>" + match.substring(space, match.length);
      });

      //values
      var numVals = 0;
      userInput = userInput.replace(/(#[\w-]+)+( [^#@]+[\w-]+)+/g, function(match, offset, string) {
        numVals += 1;
        var valueIndex = match.indexOf(" ", 1) + 1
        return match.substring(0, valueIndex-1) +
               "<span|class='value'>" + match.substring(valueIndex, match.length) + "</span>"
      });

      //keys
      var numKeys = 0;
      userInput = userInput.replace(/(#[\w-]+)+/g, function(match, offset, string) {
        numKeys += 1;
        return "<span|class='key'>" + match + " </span>"
      });

      //check if everything ok
      if(Math.abs(numKeys - numVals) > 1 || (numContacts != 1 && numKeys > 0)) {
          return "<span|class='error'>" + rawInput + " </span>";
      }

      return userInput;
    }

    userInput = highlight(userInput);

    // replace the spaces
    userInput = userInput.replace(/ /g, "&nbsp;");
    userInput = userInput.replace(/\|/g, " ");

    //Set
    $('#highlighttext').html(userInput);
  });
});
