
<x-app-layout>
    @include('french.partials.style_easy')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Niveau Facile') }}
        </h2>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
    </x-slot>

    <div class="container-custom">
        <div id="tableContainer"></div>
        <div id="paginationContainer"></div>
    </div>
</x-app-layout>
<script>
    var words = {!! json_encode($words->toArray(), JSON_HEX_TAG) !!};
    let currentPage = 1;
    let cellValues = {};
    let cellClassName = {};
    const wordsPerPage = 1;
    iWords = words.map((word) => word);
    words = words.map((word) => word.title.toUpperCase());
    containerId = "#tableContainer";
    classCssDifficulte = "facile";
    classCssUppercaseOrNot = " _blank_facile";

    function createTable() {
        let container = document.querySelector(containerId);
        container.innerHTML = "";

        let start = (currentPage - 1) * wordsPerPage;
        let end = start + wordsPerPage;
        let pageWords = words.slice(start, end);

        iWords.forEach((word, index) => {
            console.log(word)
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

                blankCell.addEventListener("dragover", function(event) {
                    event.preventDefault();
                });

                blankCell.addEventListener("touchmove", function(event) {
                    event.preventDefault();
                });

                blankCell.addEventListener("drop", function(event) {
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
                blankCell.addEventListener("click", function(event) {
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

        abc.forEach((words) => {
            let li = document.createElement("li");
            let letters = word.split("");
            letters.forEach((letter) => {
                let span = document.createElement("span");
                span.textContent = letter;
                span.id = letter;

                li.setAttribute("draggable", "true");
                li.addEventListener("dragstart", function(event) {
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
    createTable();
    displayWords();
</script>
