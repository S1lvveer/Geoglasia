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

        // Listen to hovered countries & update the country display
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

        /////////////////////////////////////////////////
        // MAP DEFORMATION: Zooming, scaling & panning //
        /////////////////////////////////////////////////
        const scale_text = map.querySelector(".current-scale");
        const pos_text = map.querySelector(".current-pos");

        let currentScale = 1;

        let translate = {scale: currentScale, translateX: 0, translateY: 0};
        let startPos = {x: 0, y: 0};
        let offset = {x: 0, y: 0};
        let mousePos = {x: 0, y: 0};

        let isPanning = false;

        // Zooming in/out effect
        const zoomSpeed = 0.2;
        function zoom(event) {
            event.preventDefault();

            // If zoomed in, scale in, else, scale out
            const oldScale = currentScale;
            currentScale += event.deltaY > 0 ? -zoomSpeed : zoomSpeed;
            currentScale = clamp(currentScale, 1, 6);

            let bounds = svg_container.getBoundingClientRect();
            mousePos.x = event.clientX - bounds.x;
            mousePos.y = event.clientY - bounds.y;

            translate.scale = currentScale;

            const contentMousePosX = (mousePos.x - translate.translateX);
            const contentMousePosY = (mousePos.y - translate.translateY);
            translate.translateX = mousePos.x - (contentMousePosX * (currentScale / oldScale));
            translate.translateY = mousePos.y - (contentMousePosY * (currentScale / oldScale));
            
            update();
        }

        // Dragging/panning effect on the map
        function mousedown(event) {
            isPanning = true;
            startPos.x = event.clientX;
            startPos.y = event.clientY;
            offset.x = translate.translateX;
            offset.y = translate.translateY;
        }
        function mouseup(event) {
            isPanning = false
        }
        function mousemove(event) {
            if (!isPanning) return;

            mousePos.x = event.clientX;
            mousePos.y = event.clientY;
            
            translate.translateX = offset.x + (mousePos.x - startPos.x);
            translate.translateY = offset.y + (mousePos.y - startPos.y);

            update();
        } 
        

        // Update the position!
        function update() {
            const matrix = `matrix(${translate.scale},0,0,${translate.scale},${translate.translateX},${translate.translateY})`;
            mapSVG.style.transform = matrix;

            let scale = translate.scale.toFixed(1);
            let pos = {
                x: (translate.translateX / scale).toFixed(0),
                y: (translate.translateY / scale).toFixed(0)
            }
            scale_text.textContent = `Scale: ${scale}x`;
            pos_text.textContent = `Position: ${pos.x}px, ${pos.y}px`;
        }
        
        map.addEventListener("wheel", zoom);
        map.addEventListener("mousedown", mousedown);
        map.addEventListener("mouseup", mouseup);
        map.addEventListener("mousemove", mousemove);
        map.addEventListener("ondrag", e => {e.preventDefault()});



    })
    .catch(error => {
        console.error("Error loading the SVG file:", error);
    })


