const map = document.querySelector(".map");
const svg_container = document.querySelector(".svg-container");

// Handle the SVG by setting its' viewbox to the boundingbox of all the paths.
function setViewBox(svg) {
    let paths = svg.querySelectorAll("path");

    let minX = Infinity;
    let minY = Infinity;
    let maxX = -Infinity;
    let maxY = -Infinity;

    paths.forEach(path => {
        let bounds = path.getBBox();
        //console.log(bounds);
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
observer.observe(map, {childList: true, subtree: true});

// All country codes that we're using!
const countryCodes = {
    "KR": "South Korea",
    "JP": "Japan",
    "CN": "China",
    "TW": "Taiwan",
    "VN": "Vietnam",
    "KH": "Cambodia",
    "TH": "Thailand",
    "LA": "Laos",
    "BD": "Bangladesh",
    "BT": "Bhutan",
    "MY": "Malaysia",
    "SG": "Singapore",
    "MN": "Mongolia",
    "NP": "Nepal",
    "IN": "India",
    "MM": "Myanmar",
};

// 
function clamp(desired, min, max) {
    return Math.min(max, Math.max(min, desired));
}

// Generate the map!
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

        // Clone all paths into our new, clean SVG
        let paths = doc.querySelectorAll("path");
        paths.forEach(path => {
            let cloned = path.cloneNode(true);

            // Check if the path is one of the ones that we're providing!
            let code = path.id;
            if (countryCodes[code]) {
                cloned.classList.add("valid-country");
            }

            svg.appendChild(cloned);
        })

        svg_container.appendChild(svg);
    })

    .then(() => { // Do something with all valid countries
        const mapSVG = svg_container.querySelector("svg");
        const hovertext = document.querySelector(".hovered-text");

        // Listen to hovered elements & update the country display
        let countries = mapSVG.querySelectorAll(".land");
        countries.forEach(country => {
            let code = country.id;
            let name = country.getAttribute("title");
            let is_valid = country.classList.contains("valid-country");

            country.addEventListener("mouseover", e => {
                hovertext.textContent = name;
                if (is_valid) {
                    hovertext.classList.add("valid");
                } else {
                    hovertext.classList.remove("valid");
                }
            })
            country.addEventListener("mouseleave", e => {
                if (hovertext.textContent == name) {
                    hovertext.textContent = "NONE";
                    hovertext.classList.remove("valid");
                }
            })
        })

        

        // Zooming effect on the map
        let currentScale = 1;
        const zoomSpeed = 0.1;

        map.addEventListener("wheel", e => {
            e.preventDefault();
            
            // If zoomed in, scale in, else, scale out
            currentScale += e.deltaY > 0 ? -zoomSpeed : zoomSpeed;
            currentScale = clamp(currentScale, 1, 5);

            let bBox = svg_container.getBoundingClientRect();
            x = (e.clientX - bBox.left);
            y = (e.clientY - bBox.top);

            mapSVG.style.transform = `scale(${currentScale})`;
            mapSVG.style.transformOrigin = `${x}px ${y}px`;

            //console.log(currentScale);
        })

        

        // Dragging/panning effect on the map
        let isPanning = false;
        let start = {x: 0, y: 0};
        let offset = {x: 0, y: 0}; // current position on map

        map.addEventListener("ondrag", e => {
            // disable other things that happen whilst dragging
            e.preventDefault();
        })
        map.addEventListener("mousedown", e => {
            isPanning = true;
            start.x = e.clientX - offset.x;
            start.y = e.clientY - offset.y;

        })
        map.addEventListener("mouseup", e => {
            isPanning = false;
        })
        map.addEventListener("mousemove", e => {
            if (!isPanning)
                return;

            console.log("moving");

            let x = e.clientX - start.x;
            let y = e.clientY - start.y;

            offset.x = x;
            offset.y = y;

            mapSVG.style.transform = `translate(${x}px, ${y}px) scale(${currentScale})`;
        })
        

    })
    .catch(error => {
        console.error("Error loading the SVG file:", error);
    })


