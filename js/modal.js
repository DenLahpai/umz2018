// get modal
var modal = document.getElementById('modal');

//get modalOpen
var modalOpen = document.getElementById('modalOpen');

//get modalClose
var modalClose = document.getElementById('modalClose');

//listen for open click
modalOpen.addEventListener('click', openModal);

//listen for close click
modalClose.addEventListener('click', closeModal);

//listen of outside onclick
window.addEventListener('click', outsideClick);

//function to open modal
function openModal() {
    modal.style.display = 'block';
}

//function to close modal
function closeModal() {
    modal.style.display = 'none';
}

//function to close modal if click outside
function outsideClick(e) {
    if (e.target == modal) {
        modal.style.display = 'none';
    }
}

//function to select guide
function selectGuide(guideId) {
    var sel = document.getElementById('guideOption' + guideId);
    sel.selected = true;
    modal.style.display = 'none';


}
