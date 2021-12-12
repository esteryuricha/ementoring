// change class management meniu position
const regionMain = document.getElementById('region-main')
const classMenu = document.getElementById('inst29')
const courseInfo = document.getElementById('inst30')
if (regionMain) {
    if (courseInfo) {
        regionMain.prepend(courseInfo)
        courseInfo.classList.add('content-container')
    }
    if (classMenu) {
        regionMain.prepend(classMenu)
        classMenu.classList.add('content-container')
    }
}

const enrollUserButton = document.getElementById('enrolusersbutton-1')
const participantForm = document.getElementById('participantsform')
if (participantForm) {
    if (enrollUserButton) {
        participantForm.prepend(enrollUserButton)
        if (enrollUserButton) enrollUserButton.classList.add('float-right')
    }
}

// move settings button beside Turn editing on on administrator
const courseHeader = document.getElementById('course-header')
const actionMenuAdmin2 = document.getElementById('action-menu-2')
if (courseHeader) {
    if (actionMenuAdmin2) {
        courseHeader.prepend(actionMenuAdmin2)
    }
}

// remove selected course from nav drawer
const courseHomeSelected = document.querySelector("[data-key='coursehome']")
if (courseHomeSelected) {
    courseHomeSelected.parentElement.remove()
}