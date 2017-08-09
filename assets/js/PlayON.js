/* Livesearch
*********************************************/
function showResult(str) {
  if (str.length <= 2 ) {
    $('.showResult li').remove();
    return;
  }else{
    if (str.length > 2) {
      console.log('digitou');
      $.post("assets/lib/livesearch.php?q="+str, function(){
        }).done(function(data){
        $('.showResult').html(data);
      });
    }
  }
}
