const mapEl = document.querySelector(".map");

// Handle the SVG by setting its' viewbox to the boundingbox of all the paths.
function setViewBox(svg) {
    let paths = svg.querySelectorAll("path");

    let minX = Infinity;
    let minY = Infinity;
    let maxX = -Infinity;
    let maxY = -Infinity;

    paths.forEach(path => {
        let bounds = path.getBBox();
        console.log(bounds);
        minX = Math.min(minX, bounds.x);
        minY = Math.min(minY, bounds.y);
        maxX = Math.max(maxX, bounds.x + bounds.width);
        maxY = Math.max(maxY, bounds.y + bounds.height);
    })

    svg.setAttribute('viewBox', `${minX} ${minY} ${maxX - minX} ${maxY - minY}`);
}

// Detect whenever a child is added (in this case, the SVG of the map)
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
observer.observe(mapEl, {childList: true, subtree: true});

// Fetch low quality asian country map
fetch("../assets/asiaLow.svg")
    .then(response => response.text())
    .then(svgText => {
        // Loaded the file. Now I have to parse it
        const parser = new DOMParser();
        const doc = parser.parseFromString(svgText, 'image/svg+xml');

        // Create the SVG for the whole map
        let svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute("width", "100%");
        svg.setAttribute("height", "100%");


        let paths = doc.querySelectorAll("path");
        paths.forEach(path => {
            svg.appendChild(path.cloneNode(true));
        })


        mapEl.appendChild(svg);
    })
    .catch(error => {
        console.error("Error loading the SVG file:", error);
    })