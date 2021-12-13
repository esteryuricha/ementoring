// change class management meniu position
const regionMain = document.getElementById('region-main')
if (regionMain) {
    // different courseInfo(29,31,33) and classMenu(30,32,34) id on PARTICIPANTS, GROUPS, GRADE page
    // courseInfo
    const courseInfo = ['inst30', 'inst32', 'inst34']
    for (const element of courseInfo) {
        if (document.getElementById(element)) {
            const courseInfo = document.getElementById(element)
            regionMain.prepend(courseInfo)
            courseInfo.classList.add('content-container')
        }    
    }
    // classMenu
    const classMenu = ['inst29', 'inst31', 'inst33']
    for (const element of classMenu) {
        if (document.getElementById(element)) {
            const classMenu = document.getElementById(element)
            regionMain.prepend(classMenu)
            classMenu.classList.add('content-container')
        }
    } 
}

// class management -> PARTICIPANTS DOM manipulation
const participantForm = document.getElementById('participantsform')
if (participantForm) {
    const enrollUserButton = document.getElementById('enrolusersbutton-1')
    if (enrollUserButton) {
        participantForm.prepend(enrollUserButton)
        if (enrollUserButton) {
            enrollUserButton.classList.add('float-right')
        }
    }
    const participantFormContainer = participantForm.parentElement
    if (participantFormContainer) {
        participantFormContainer.style.padding = 0
        participantFormContainer.style.boxShadow = 'none'
        const participantWrapper = participantFormContainer.parentElement
        if (participantWrapper) {
            participantWrapper.classList.add('content-container')
            const participantTitle = participantWrapper.children[1] // the <h2> title
            if (participantTitle) {
                participantTitle.classList.add('title-base')
            }
        }
    }
}

// class management -> GROUPS DOM manipulation
const groupMenuTabs = document.querySelector('#region-main > div[role="main"] div.groupdisplay')
if (groupMenuTabs) {
    const groupContainer = groupMenuTabs.parentElement
    if (groupContainer) {
        const groupContainerTitle = groupContainer.children[2] // the <h2> title
        if (groupContainerTitle) {
            groupContainer.prepend(groupContainerTitle)
            groupContainerTitle.classList.add('title-base')
        }
        groupContainer.classList.add('content-container')
        groupMenuTabs.style.boxShadow = "none"
        groupMenuTabs.style.padding = 0
        // move to below class management menu
        regionMain.append(groupContainer)
    }
}



// move settings button beside Turn editing on on administrator
const courseHeader = document.getElementById('course-header')
if (courseHeader) {
    const actionMenuAdmin2 = document.getElementById('action-menu-2')
    if (actionMenuAdmin2) {
        courseHeader.prepend(actionMenuAdmin2)
    }
}

// remove selected course from nav drawer
const courseHomeSelected = document.querySelector("[data-key='coursehome']")
if (courseHomeSelected) {
    courseHomeSelected.parentElement.remove()
}