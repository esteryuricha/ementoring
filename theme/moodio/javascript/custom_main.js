// change class management meniu position
const regionMain = document.getElementById('region-main')
const classMenu = document.getElementById('inst29')
const courseInfo = document.getElementById('inst30')

regionMain.prepend(courseInfo)
courseInfo.classList.add('content-container')
regionMain.prepend(classMenu)
classMenu.classList.add('content-container')

const enrollUserButton = document.getElementById('enrolusersbutton-1')
const participantForm = document.getElementById('participantsform')
participantForm.prepend(enrollUserButton)
enrollUserButton.classList.add('float-right')


