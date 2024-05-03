let words = [];
let dodo = [];
let imageInformations = [];
        words = data.map((word) => word.title);
        imageInformations = data.map((word) => word);
        let abc = [
            "A",
            "B",
            "C",
            "D",
            "E",
            "F",
            "G",
            "H",
            "I",
            "J",
            "K",
            "L",
            "M",
            "N",
            "O",
            "P",
            "Q",
            "R",
            "S",
            "T",
            "U",
            "V",
            "W",
            "X",
            "Y",
            "Z",
        ];
        let currentPage = 1;
        let cellValues = {};
        let cellClassName = {};
        const wordsPerPage = 1;
        words = words.map((word) => word.toUpperCase());
        let containerId = "";
        let classCssDifficulte = "";
        let classCssUppercaseOrNot = "";
        let good = new Audio("../assets/audio/good.mp3");
        let bad = new Audio("../assets/audio/bad.mp3");
        let win = new Audio("../assets/audio/win.mp3");
        let canva = document.querySelector("canvas");

        if (document.querySelector("#tableContainer")) {
            containerId = "#tableContainer";
            classCssDifficulte = "facile";
            classCssUppercaseOrNot = " _blank_facile";
        }
        if (document.querySelector("#tableContainerDifficile")) {
            containerId = "#tableContainerDifficile";
            classCssDifficulte = "difficile";
            classCssUppercaseOrNot = " _blank_difficile";
        }

        if (document.querySelector("#tableContainerMoyen")) {
            containerId = "#tableContainerMoyen";
            classCssDifficulte = "moyen";
            classCssUppercaseOrNot = " _blank_moyen";
        }

        function createTable() {
            let container = document.querySelector(containerId);
            container.innerHTML = "";

            let start = (currentPage - 1) * wordsPerPage;
            let end = start + wordsPerPage;
            let pageWords = words.slice(start, end);
            let iWords = imageInformations.slice(start, end);

            iWords.forEach((word, index) => {
                let img_path = word.path;
                word = word.title.toUpperCase();
                let div = document.createElement("div");
                div.classList.add("exo-content");
                let img = document.createElement("img");
                img.src = `https://kidoos.fr/${img_path}`;
                div.appendChild(img);

                let table = document.createElement("table");
                let tbody = document.createElement("tbody");

                let row = document.createElement("tr");
                row.classList.add(classCssDifficulte);
                let blankRow = document.createElement("tr");

                for (let count = 0; count < word.length; count++) {
                    let cell = document.createElement("td");
                    cell.textContent = word[count];
                    row.appendChild(cell);
                    cell.classList.add(`${index}_cell_${word[count]}`);

                    let blankCell = document.createElement("td");
                    let cellKey = `${currentPage}_${index}_${count}`;

                    if (cellValues[cellKey]) {
                        blankCell.textContent = cellValues[cellKey];
                    }

                    blankCell.className =
                        cell.className +
                        "_verif blank-cell-script" +
                        classCssUppercaseOrNot;
                    if (cellClassName[cellKey]) {
                        blankCell.className +=
                            " " + cellClassName[cellKey].join(" ");
                    }

                    blankCell.addEventListener("dragover", function (event) {
                        event.preventDefault();
                    });

                    blankCell.addEventListener("touchmove", function (event) {
                        event.preventDefault();
                    });

                    blankCell.addEventListener("drop", function (event) {
                        event.preventDefault();
                        let data = event.dataTransfer.getData("text/plain");
                        this.textContent = data;

                        let previousRow =
                            this.parentNode.previousElementSibling;
                        let correspondingCell =
                            previousRow.children[this.cellIndex];

                        if (
                            correspondingCell.textContent === this.textContent
                        ) {
                            this.classList.add("cl-green");
                            this.classList.remove("cl-red");
                            good.play();
                        } else {
                            this.classList.add("cl-red");
                            this.classList.remove("cl-green");
                            bad.play();
                        }
                        cellValues[cellKey] = data;
                        tableCustom =
                            document.querySelectorAll("table tbody tr td");
                        lengthTableCustom = tableCustom.length / 2;
                        let nextButton = document.querySelector(".next-button");
                        counterClassGreen = 0;
                        tableCustom.forEach((e) => {
                            if (e.classList.contains("cl-green")) {
                                counterClassGreen++;
                            }
                        });
                        if (counterClassGreen === lengthTableCustom) {
                            canva.classList.remove("d-none");
                            setTimeout(() => {
                                win.play();
                            }, 2000);

                            setTimeout(() => {
                                canva.classList.add("d-none");
                                nextButton.click();
                            }, 5000);
                        }

                        cellClassName[cellKey] = Array.from(this.classList);
                    });
                    blankCell.addEventListener("click", function (event) {
                        this.textContent = "";
                        this.classList.remove("cl-red");
                        this.classList.remove("cl-green");
                        delete cellValues[cellKey];
                        delete cellClassName[cellKey];
                    });
                    blankRow.appendChild(blankCell);
                }

                tbody.appendChild(row);
                tbody.appendChild(blankRow);

                table.appendChild(tbody);
                div.appendChild(table);
                container.appendChild(div);
            });
        }

        function displayWords() {
            let container = document.querySelector(containerId);
            let ul = document.createElement("ul");

            abc.forEach((word) => {
                let li = document.createElement("li");
                let letters = word.split("");
                letters.forEach((letter) => {
                    let span = document.createElement("span");
                    span.textContent = letter;
                    span.id = letter;

                    li.setAttribute("draggable", "true");
                    li.addEventListener("dragstart", function (event) {
                        event.dataTransfer.setData(
                            "text/plain",
                            this.textContent
                        );
                    });
                    li.appendChild(span);
                });

                li.id = word;
                li.className = `letter-drag${classCssUppercaseOrNot}`;

                ul.appendChild(li);
            });

            container.appendChild(ul);
        }

        function createPagination() {
            let container = document.querySelector("#paginationContainer");
            let totalPages = words.length;
            let counter = 1;
            let buttonPrevious = document.createElement("button");
            buttonPrevious.textContent = "<";
            buttonPrevious.classList.add("pagination-button");
            let buttonNext = document.createElement("button");
            buttonNext.textContent = ">";
            buttonNext.classList.add("pagination-button");
            buttonNext.classList.add("next-button");
            container.appendChild(buttonPrevious);
            container.appendChild(buttonNext);
            buttonNext.addEventListener("click", function () {
                if (counter === totalPages) {
                } else {
                    counter = counter + 1;
                    currentPage = counter;
                    console.log(counter);
                    createTable("color-red", "#tableContainer");
                    createTable("color-red", "#tableContainerDifficile");
                    displayWords();
                }
            });
            buttonPrevious.addEventListener("click", function () {
                if (counter === 1) {
                    console.log(counter);
                } else {
                    counter = counter - 1;
                    console.log(counter);
                    currentPage = counter;
                    createTable("color-red", "#tableContainer");
                    createTable("color-red", "#tableContainerDifficile");
                    displayWords();
                }
            });
        }
        createPagination();
        createTable();
        displayWords();
    

document.addEventListener("DOMContentLoaded", (event) => {
    var paginationContainer = document.querySelector("#paginationContainer");

    paginationContainer.addEventListener("click", function (e) {
        if (e.target && e.target.nodeName == "BUTTON") {
            // Remove active class from all buttons
            var buttons = document.querySelectorAll(".pagination-button");
            buttons.forEach((btn) => btn.classList.remove("active"));

            // Add active class to the clicked button
            e.target.classList.add("active");
        }
    });
});
