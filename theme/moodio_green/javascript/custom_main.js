const mediaQuery = window.matchMedia('(min-width: 768px)')

// change class management meniu position
if (document.getElementById('region-main')) {
    const regionMain = document.getElementById('region-main')
    if (regionMain) {
        if (document.querySelector('.block_courseinformation')) {
            const courseInfo = document.querySelector('.block_courseinformation')
            regionMain.prepend(courseInfo)
            // courseInfo.classList.add('content-container')
        }
        if (document.querySelector('.block_courseheader')) {
            const classMenu = document.querySelector('.block_courseheader')
            regionMain.prepend(classMenu)
            // classMenu.classList.add('content-container')
        }
    }
}

// class management -> PARTICIPANTS DOM manipulation
if (document.getElementById('participantsform')) {
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
}

// class management -> GROUPS DOM manipulation
if (document.querySelector('#region-main > div[role="main"] div.groupdisplay')) {
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
            const regionMain = document.getElementById('region-main')
            regionMain.append(groupContainer)
        }
    }
}

if (document.querySelector('div[role="main"] .grade-navigation')) {
    const gradeNav = document.querySelector('div[role="main"] .grade-navigation')
    if (gradeNav) {
        gradeNav.style.padding = 0
        gradeNav.style.boxShadow = 'none'
        const gradeWrapper = gradeNav.parentElement
        if (gradeWrapper) {
            gradeWrapper.classList.add('content-container')
        }
        const gradeTitle = gradeWrapper.children[1]
        if (gradeTitle) {
            gradeTitle.classList.add('title-base')
        }
    }
}

// add .content-container to ADD a new Schedule
if (document.getElementById('id_modstandardelshdr')) {
    const addScheduleModule = document.getElementById('id_modstandardelshdr')
    if (addScheduleModule) {
        const addScheduleForm = addScheduleModule.parentElement.parentElement
        if (addScheduleForm) {
            addScheduleForm.classList.add('content-container')
        }
        const addScheduleTitle = addScheduleForm.children[1]
        if (addScheduleTitle) {
            addScheduleTitle.classList.add('title-base')
        }
    }
}
// add .content-container to upload users
if (document.getElementById('id_settingsheader')) {
    const uploadUsersHeader = document.getElementById('id_settingsheader')
    if (uploadUsersHeader) {
        const uploadUsersForm = uploadUsersHeader.parentElement.parentElement
        if (uploadUsersForm) {
            uploadUsersForm.classList.add('content-container')
        }
        const uploadUsersTitle = uploadUsersForm.children[1]
        if (uploadUsersTitle) {
            uploadUsersTitle.classList.add('title-base')
        }
    }
}

// move settings button beside Turn editing on on administrator
if (document.getElementById('course-header')) {
    const courseHeader = document.getElementById('course-header')
    if (courseHeader) {
        const actionMenuAdmin2 = document.getElementById('action-menu-2')
        if (actionMenuAdmin2) {
            courseHeader.prepend(actionMenuAdmin2)
        }
    }
}

// remove selected course from nav drawer
if (document.querySelector('[data-key="coursehome"]')) {
    const courseHomeSelected = document.querySelector('[data-key="coursehome"]')
    if (courseHomeSelected) {
        courseHomeSelected.parentElement.remove()
    }
}
// remove badges from nav drawer
if (document.querySelector('[data-key="badgesview"]')) {
    const badgesViewMenu = document.querySelector('[data-key="badgesview"]')
    if (badgesViewMenu) {
        badgesViewMenu.parentElement.remove()
    }
}
// remove competencies from nav drawer
if (document.querySelector('[data-key="competencies"]')) {
    const competenciesMenu = document.querySelector('[data-key="competencies"]')
    if (competenciesMenu) {
        competenciesMenu.parentElement.remove()
    }
}
if (document.querySelectorAll('.media-left .icon.fa.fa-folder-o.fa-fw')) {
    const courseTopicsOnDrawer = document.querySelectorAll('.media-left .icon.fa.fa-folder-o.fa-fw')
    if (courseTopicsOnDrawer) {
        for (const element of courseTopicsOnDrawer) {
            element.parentElement.parentElement.parentElement.parentElement.parentElement.remove()
        }
    }
}

// only on desktop
if (mediaQuery.matches) {
    // move mentors, managers, and participants inside an <ul>
    if (document.querySelector('[data-parent-key="myhome"]')) {
        const userOnNavDrawer = document.querySelector('[data-parent-key="myhome"]').parentElement
        if (userOnNavDrawer) {
            userOnNavDrawer.setAttribute("class", "user-subnav-parent")
            const userSub = document.createElement("ul")
            userSub.setAttribute("class", "user-subnav")
            userOnNavDrawer.appendChild(userSub)

            const userMenuCheck = document.querySelectorAll('nav.list-group ul li a div div span.media-body')
            if (userMenuCheck) {
                for (const element of userMenuCheck) {
                    // console.log(element.innerHTML)
                    if (element.innerHTML == "Managers" || element.innerHTML == "Mentors" || element.innerHTML == "Participants") {
                        // console.log(element.innerHTML + " selected")
                        const targetedMenu = element.parentElement.parentElement.parentElement.parentElement
                        if (targetedMenu) {
                            userSub.prepend(targetedMenu)
                        }
                    }
                }
            }
        }
    }
}

// move search on participant enrollment to top
if (document.querySelector('#assignform .generaltable.generalbox.boxaligncenter')) {
    const searchExistingWrapper = document.querySelector('#assignform .generaltable.generalbox.boxaligncenter #existingcell #removeselect_wrapper')
    if (searchExistingWrapper) {
        const searchExistingForm = document.querySelector('#assignform .generaltable.generalbox.boxaligncenter #existingcell #removeselect_wrapper .form-inline')
        searchExistingForm.style.minHeight = '4rem'
        searchExistingForm.childNodes[1].placeholder = 'Search'
        searchExistingWrapper.prepend(searchExistingForm)
    }
}
if (document.querySelector('#assignform .generaltable.generalbox.boxaligncenter')) {
    const searchEnrollableWrapper = document.querySelector('#assignform .generaltable.generalbox.boxaligncenter #potentialcell #addselect_wrapper')
    if (searchEnrollableWrapper) {
        const searchEnrollableForm = document.querySelector('#assignform .generaltable.generalbox.boxaligncenter #potentialcell #addselect_wrapper .form-inline')
        searchEnrollableForm.style.minHeight = '4rem'
        searchEnrollableForm.childNodes[1].placeholder = 'Search'
        searchEnrollableWrapper.prepend(searchEnrollableForm)
    }
}