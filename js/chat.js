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

    function highlight(userInput) {
      // Apply the highlighting
      console.log("-------------------------")
      console.log(userInput)
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
      userInput = userInput.replace(/\B\@[\w| ]{3,}/i, function(match, offset, string) {
        var space = match.lastIndexOf(" ")
        return "<span|class='contact'>" + match.substring(0, space) + "</span>" + match.substring(space, match.length);
      });

      //values
      userInput = userInput.replace(/(#[\w-]+)+( [^#@]+[\w-]+)+/g, function(match, offset, string) {
        var valueIndex = match.indexOf(" ", 1) + 1
        return match.substring(0, valueIndex-1) +
               "<span|class='value'>" + match.substring(valueIndex, match.length) + "</span>"
      });

      //keys
      userInput = userInput.replace(/(#[\w-]+)+/g, function(match, offset, string) {
        return "<span|class='key'>" + match + " </span>"
      });

      return userInput;
    }

    userInput = highlight(userInput);
    console.log(userInput);

    // replace the spaces
    userInput = userInput.replace(/ /g, "&nbsp;");
    userInput = userInput.replace(/\|/g, " ");

    //Set
    console.log(userInput)
    $('#highlighttext').html(userInput);
  });
});
