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

if (document.getElementById('choose_category')) {
    let input = document.getElementById('choose_category');

    input.addEventListener('change', function() {
    });
}
