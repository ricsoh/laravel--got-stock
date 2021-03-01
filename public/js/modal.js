function onloadImageModal(recModal, recID, recModalID, recSpanID, recCaption){
    // Get the modal
    var modal = document.getElementById(recModal);
  
    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById(recID);
    var modalImg = document.getElementById(recModalID);
    var captionText = document.getElementById(recCaption);
    img.onclick = function(){
      modal.style.display = "block";
      modalImg.src = this.src;
      captionText.innerHTML = this.alt;
    }
  
    // Get the <span> element that closes the modal
    var span = document.getElementById(recSpanID);
  
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() { 
      modal.style.display = "none";
    }
}