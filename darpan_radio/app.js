const menu = document.querySelector("#mobile-menu");
const menuLinks = document.querySelector(".navbar__menu");
const navLogo = document.querySelector("#navbar__logo");
const homeBtn = document.querySelector("#home-page");
const dropDownBtn1 = document.querySelector(".sub-page1");
const dropDownBtn2 = document.querySelector(".sub-page2");
const dropDownBtn3 = document.querySelector(".sub-page3");
const dropDownBtn4 = document.querySelector(".sub-page4");
const dropDownBtn5 = document.querySelector(".sub-page5");
const dropDownBtn6 = document.querySelector(".sub-page6");
const dropDownBtn7 = document.querySelector(".sub-page7");
const dropDownBtn8 = document.querySelector(".sub-page8");

const helper = (item) => {
  item.classList.remove("active");
};

const mobileMenu = () => {
  menu.classList.toggle("is-active");
  menuLinks.classList.toggle("active");
};

menu.addEventListener("click", mobileMenu);

document.addEventListener("click", (e) => {
  const isDropdownButton = e.target.matches("[data-dropdown-button]");
  const isLink = e.target.matches("[data-link]");
  if (
    !isDropdownButton &&
    e.target.closest("[data-dropdown]") != null &&
    !isLink
  ) {
    return;
  }

  let currentDropdown;
  let currentLink;

  if (isDropdownButton) {
    currentDropdown = e.target.closest("[data-dropdown]");
    currentDropdown.classList.toggle("active");
  }
  if (isLink) {
    currentLink = e.target.closest("[data-link]").dataset.link;
    document.querySelectorAll("[data-wrapper]").forEach((ele) => {
      if (ele.dataset.wrapper === currentLink) {
        ele.classList.add("active");
      } else {
        helper(ele);
      }
    });
  }

  document.querySelectorAll("[data-dropdown].active").forEach((dropdown) => {
    if (dropdown === currentDropdown) {
      return;
    } else {
      dropdown.classList.remove("active");
    }
  });
});

const hideMobileMenu = () => {
  const menuBars = document.querySelector(".is-active");
  if (window.innerWidth <= 768 && menuBars) {
    menu.classList.toggle("is-active");
    menuLinks.classList.remove("active");
    document.querySelectorAll("[data-wrapper]").forEach((wrapper) => {
      if (wrapper.dataset.wrapper === "s0") {
        wrapper.classList.add("active");
      } else {
        wrapper.classList.remove("active");
      }
    });
  }
};

const triggleHome = () => {
  document.querySelectorAll("[data-wrapper]").forEach((ele) => {
    if (ele.dataset.wrapper === "s0") {
      ele.classList.add("active");
    } else {
      helper(ele);
    }
  });
  window.history.pushState({}, document.title, "/");
  hideMobileMenu();
};
homeBtn.addEventListener("click", triggleHome);
navLogo.addEventListener("click", triggleHome);
dropDownBtn1.addEventListener("click", hideMobileMenu);
dropDownBtn2.addEventListener("click", hideMobileMenu);
dropDownBtn3.addEventListener("click", hideMobileMenu);
dropDownBtn4.addEventListener("click", hideMobileMenu);
dropDownBtn5.addEventListener("click", hideMobileMenu);
dropDownBtn6.addEventListener("click", hideMobileMenu);
dropDownBtn7.addEventListener("click", hideMobileMenu);
dropDownBtn8.addEventListener("click", hideMobileMenu);
