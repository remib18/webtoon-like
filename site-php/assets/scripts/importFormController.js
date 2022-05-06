const step1 = document.getElementById('step-1')
const step2 = document.getElementById('step-2')
const svg = document.getElementById('completion')
let current = 1

// Todo: Split the form in two and handle the click on the forme

function next() {
    step1.classList.toggle('current')
    step2.classList.toggle('current')
    svg.classList.toggle('switched')
    current = 2
}

function submit(e) {
    if (current === 1) e.preventDefault()
}

