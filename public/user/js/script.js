//@ts-nocheck

// header scolled
const header = document.querySelector('.header-main-block');

window.onscroll = () => {
    if (document.documentElement.scrollTop > 50) {
        header.classList.add('header-scrolled');
    } else {
        header.classList.remove('header-scrolled');
    }
}


// nav active when scroll
const sections = document.querySelectorAll("section");
const navLinks = document.querySelectorAll('.nav-link');

let currentSection = 'home';

window.addEventListener('scroll', () => {
    sections.forEach(section => {
        if (window.scrollY >= (section.offsetTop - 200)) {
            currentSection = section.id;
        }
    })

    navLinks.forEach(navlink => {

        if (navlink.href.includes(currentSection) && currentSection) {
            document.querySelector('.active-nav').classList.remove('active-nav');
            navlink.classList.add('active-nav');
        }
    })
})


// navlink hide
let navbar = document.querySelectorAll(".nav-link");
let navCollapse = document.querySelector(".navbar-collapse.collapse");

navbar.forEach(function (e) {
    e.addEventListener("click", function () {
        navCollapse.classList.remove("show");

        navbar.forEach(function (link) {
            link.classList.remove("active-nav");
        });
        e.classList.add("active-nav");

    });
});


// dropdown
const dropdownEl = document.querySelector(".drop-down");
const dropdownArrow = document.querySelector(".fa-caret-down");

dropdownArrow.addEventListener("click", (e) => {
    e.stopPropagation();
    dropdownEl.classList.toggle("drop-down-active")
})

document.addEventListener("click", (event) => {
    // If the clicked element is not part of the dropdown, close it
    if (!dropdownEl.contains(event.target) && !dropdownArrow.contains(event.target)) {
        dropdownEl.classList.remove("drop-down-active");
    }
});


// section btn linkup
const serviceBtn = document.querySelector("#service-btn");
serviceBtn.addEventListener("click", () => {
    window.location.href = "#service"
})

const buyBtn = document.querySelector("#buy-btn");
buyBtn.addEventListener("click", () => {
    window.location.href = "#token"
})

const aboutBtn = document.querySelector("#about-btn");
aboutBtn.addEventListener("click", () => {
    window.location.href = "#docs"
})



// count down timmer
const DayEl = document.getElementById("days");
const HoursEl = document.getElementById("hours");
const MinuteEl = document.getElementById("minutes");
const SecondEl = document.getElementById("seconds");

// set upcomming date here
const UpcommingTime = "18 November 2024";

function CountDown() {
    const UpcommingDate = new Date(UpcommingTime);
    const currentDate = new Date();

    const totalSeconds = (UpcommingDate - currentDate) / 1000;

    const days = Math.floor((totalSeconds / 3600) / 24);
    const hours = Math.floor((totalSeconds / 3600) % 24);
    const minutes = Math.floor((totalSeconds / 60) % 60);
    const seconds = Math.floor((totalSeconds % 60));

    DayEl.innerHTML = formateTime(days);
    HoursEl.innerHTML = formateTime(hours);
    MinuteEl.innerHTML = formateTime(minutes);
    SecondEl.innerHTML = formateTime(seconds);

    if (UpcommingDate <= currentDate) {
        DayEl.innerHTML = "00";
        HoursEl.innerHTML = "00";
        MinuteEl.innerHTML = "00";
        SecondEl.innerHTML = "00";
    }

}

function formateTime(time) {
    return time < 10 ? (`0${time}`) : time;
}

CountDown();


setInterval(CountDown, 1000);


// road map carousel

$('.owl-carousel.owl-theme').owlCarousel({
    loop: false,
    margin: 10,
    nav: true,
    dots: false,
    navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
    responsive: {
        0: {
            items: 2
        },
        600: {
            items: 3
        },
        1000: {
            items: 4
        }
    }
})

// scroll up activation
$(function () {
    $.scrollUp();
});
