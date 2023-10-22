const countryGrid = document.querySelector(".country-grid");

// Handle the SVG by setting its' viewbox to the boundingbox of the path.
function setViewBox(svg) {
    let path = svg.querySelector("path");

    let bounds = path.getBBox();
    svg.setAttribute('viewBox', `${bounds.x} ${bounds.y} ${bounds.width} ${bounds.height}`);
}

// Detect whenever a child is added (in this case, an SVG).
function childAdded(mutationList) {
    mutationList.forEach(mutation => {
        mutation.addedNodes.forEach(node => {
            if (node.tagName === 'svg') {
                setViewBox(node);
            }
        })
    })
}

const observer = new MutationObserver(childAdded)
observer.observe(countryGrid, {childList: true, subtree: true});


// Use a fetch request to open one of the asian country svg files (in this case the lower quality one)
fetch("../assets/asiaLow.svg")
    .then(response => response.text())
    .then(svgText => {
        // Loaded the file. Now I have to parse it
        const parser = new DOMParser();
        const doc = parser.parseFromString(svgText, 'image/svg+xml');

        function createCountrySVG(countryCode) {
            // Find the country's path in the svg file and single it out 
            let path = doc.getElementById(countryCode);
            if (path) {
                let svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                
                svg.setAttribute('width', '100');
                svg.setAttribute('height', '100');

                //console.log(countryCode, "appended");
                svg.appendChild(path.cloneNode(true));

                return svg;
            }

            return null; // no country path found
        }

        // Loop through all of the p elements with a data-country attribute, create an SVG in it!
        const countries = document.querySelectorAll(".country-grid p");
        countries.forEach(country => {
            let countryCode = country.getAttribute("data-country");
            let svg = createCountrySVG(countryCode);
            if (svg) {
                country.appendChild(svg);
            }
        })
    })
    .catch(error => {
        console.error("Error loading the SVG file:", error);
    })