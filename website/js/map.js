// Declare starter variables!
const map = document.querySelector(".map");
const svg_container = document.querySelector(".svg-container");

const bookingMain = document.querySelector(".booking");
const booking = {
    image: bookingMain.querySelector(".place-image"),
    name: bookingMain.querySelector(".info .name"),
    desc: bookingMain.querySelector(".info .desc"),
    startdate: bookingMain.querySelector(".date-info .startdate"),
    enddate: bookingMain.querySelector(".date-info .enddate"),
    form: {
        place_id: bookingMain.querySelector("form #place_id"),
        user_id: bookingMain.querySelector("form #user_id"),
        book_date: bookingMain.querySelector("form #book_date"),
        book_start: bookingMain.querySelector("form #book_start"),
        book_end: bookingMain.querySelector("form #book_end"),
    }
};

//console.log(booking);

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

        /////////////////////////////////////////////////
        // COUNTRY VALIDATION: Valid and invalid tags! //
        /////////////////////////////////////////////////


        const mapSVG = svg_container.querySelector("svg");
        const hovertext = document.querySelector(".hovered-text");

        let selected;
        function setSelectedCountry(country) {
            // Deselect by clicking on air
            if (!country && selected) {
                selected.classList.remove("selected");
                selected = null;
                return;
            }
            if (!country) return;
            if (!country.classList.contains("valid-country")) return;

            // Select by clicking on country path
            if (selected) {
                selected.classList.remove("selected");
            }
            selected = country;
            country.classList.add("selected")

            hovertext.classList.add("selected");
        }

        // Listen to hovered countries & update the country display
        let countries = mapSVG.querySelectorAll(".land");
        countries.forEach(country => {
            let code = country.id;
            let name = country.getAttribute("title");
            let is_valid = country.classList.contains("valid-country");

            country.addEventListener("mouseover", e => {
                hovertext.textContent = name;

                if (country != selected) {
                    hovertext.classList.remove("selected");
                }

                if (is_valid) {
                    hovertext.classList.add("valid");
                } else {
                    hovertext.classList.remove("valid");
                }
                //console.log(country.getBoundingClientRect());
            })
            country.addEventListener("mouseleave", e => {
                if (hovertext.textContent == name) {
                    hovertext.textContent = "NONE";
                    hovertext.classList.remove("valid");
                }

                if (selected) {
                    hovertext.textContent = selected.getAttribute("title");
                    hovertext.classList.add("selected");
                }
            })
            country.addEventListener("click", e => {
                setSelectedCountry(country);
            })
        })

        mapSVG.addEventListener("click", e => {
            if (e.target.nodeName == "svg") {
                setSelectedCountry();
                hovertext.textContent = "NONE";
                hovertext.classList.remove("valid");
                hovertext.classList.remove("selected");
            }
        })


        ////////////////////////////////////////////////////////
        // MAP MARKERS: Add marker svgs to all "mark" objects //
        ////////////////////////////////////////////////////////

        const markers = map.querySelector(".markers");

        // Get path from countryCode
        function getPathFromCountryCode(countryCode) {
            return mapSVG.querySelector(`#${countryCode}`);
        }

        // Calculate the pixel ratio [for proper saving of pixels in the database]
        function pxToPathPercent(pixels, relativePath) {
            let bounds = relativePath.getBoundingClientRect();
            return {
                x: pixels.x / bounds.width,
                y: pixels.y / bounds.height
            };
        }
        function pathPercentToPx(percentages, relativePath) {
            let bounds = relativePath.getBoundingClientRect();
            return {
                x: percentages.x * bounds.width,
                y: percentages.y * bounds.height
            };
        }

        // Calculate the relative position of the element based off path
        const size = 25;
        const moveLeft = size/2, moveDown = size; // The marker is 25 pixels, so for it to mark properly, origin point has to be bottom middle
        function getRelativeToCountry(path) {
            let mapBounds = svg_container.getBoundingClientRect();
            let pathBounds = path.getBoundingClientRect();
            let x = pathBounds.left - mapBounds.left;
            let y = pathBounds.top - mapBounds.top;
            
            return {x: x, y: y};
            // return {x: 505, y: 52}; 
            // ^ this is the coords Mongolia should be at
        }

        const markerList = markers.querySelectorAll(".marker");
        function updateMarkers() {
            markerList.forEach(marker => {
                // Find the country path this marker should be relative to
                let countryCode = marker.getAttribute('data-country-code');
                let path = getPathFromCountryCode(countryCode);

                // Get the offset variables from the database
                let offsetText = marker.getAttribute("data-offset");
                let offsetSplit = offsetText.split(', ');

                // Save the offset variables (they are seperated by a space and a comma)
                let offsetX = 0, offsetY = 0;
                let offsets = {x: 0, y: 0};
                if (offsetSplit.length >= 2) {
                    offsetX = parseFloat(offsetSplit[0]);
                    offsetY = parseFloat(offsetSplit[1]);

                    offsets = pathPercentToPx({x: offsetX, y: offsetY}, path);
                }

                let relativePos = getRelativeToCountry(path);

                let x = (relativePos.x - moveLeft) + offsets.x;
                let y = (relativePos.y - moveDown) + offsets.y;
                marker.style.left = `${x}px`;
                marker.style.top = `${y}px`;
                //console.log(relativePos);
            })
        }

        window.addEventListener("resize", updateMarkers);

        // Fetch the marker svg to put everywhere [cosmetic change - add the marker]
        fetch("../assets/marker-red.svg")
            .then(response2 => response2.text())
            .then(svgText2 => {
                // Loaded the file. Parse
                const parser = new DOMParser();
                const doc = parser.parseFromString(svgText2, 'image/svg+xml');

                let markerSVG = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                markerSVG.setAttribute("width", "512");
                markerSVG.setAttribute("height", "512");

                let g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
                markerSVG.appendChild(g);

                // Clone all paths to the group
                let paths = doc.querySelectorAll("path");
                paths.forEach(path => {
                    let cloned = path.cloneNode(true);
                    g.appendChild(cloned);
                })

                // Now, markerSVG is our marker! We can clone it to all ".mark" objects.
                markerList.forEach(marker => {
                    let mark = marker.querySelector(".mark");
                    mark.appendChild(markerSVG.cloneNode(true));
                })
            })
            .then(() => {
                // Update all marker position for the first time!
                setTimeout(() => {
                    markers.style.visibility = 'visible';
                    updateMarkers();
                }, 350)
                
            })
        
        //////////////////////////////////////////////////
        // CREATE BOOKING PLACES FROM MARKER DATA VARS! //
        //////////////////////////////////////////////////

        // Set the place info under the map for booking.
        const placeholderImg = "https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png";
        function setPlaceInfo(marker) {
            // data-country-code='$countryCode' data-offset='$locationOffset' data-img='$cityIMG' data-desc='$city_desc' data-name='$placeName' data-country='$countryName'
            let data = {
                country: marker.getAttribute("data-country"),
                place: marker.getAttribute("data-name"),
                placedesc: marker.getAttribute("data-desc"),
                countrycode: marker.getAttribute("data-country-code"),
                image: marker.getAttribute("data-img"),
                date_start: marker.getAttribute("data-datestart"),
                date_end: marker.getAttribute("data-dateend")
            };
            console.log(data.placedesc);

            // Fill up the details
            if (data.image.length == 0) 
                data.image = placeholderImg;

            booking.image.src = data.image;
            booking.name.textContent = `${data.place}, ${data.country}`;
            booking.desc.textContent = `${data.placedesc}`;
            booking.startdate.textContent = `Start date: ${data.date_start}`;
            booking.enddate.textContent = `End date: ${data.date_end}`;

            // Fill up the form
            booking.form.place_id
        }

        markerList.forEach(marker => {
            marker.addEventListener("click", e => {
                setPlaceInfo(marker);
            });
        });


        /////////////////////////////////////////////////
        // MAP DEFORMATION: Zooming, scaling & panning //
        /////////////////////////////////////////////////
        const scale_text = map.querySelector(".current-scale");
        const pos_text = map.querySelector(".current-pos");

        let currentScale = 1;

        let translate = {scale: currentScale, translateX: 0, translateY: 0};
        let startPos = {x: 0, y: 0, startScale: currentScale};
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
            startPos.startScale = currentScale;
            offset.x = translate.translateX;
            offset.y = translate.translateY;
        }
        function mouseup(event) {
            isPanning = false
        }
        function mousemove(event) {
            if (!isPanning) return;

            //const ratio = currentScale / startPos.startScale;

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
            pos_text.textContent = `Position: ${-pos.x}px, ${-pos.y}px`;

            setTimeout(updateMarkers, 50);
        }
        
        map.addEventListener("wheel", zoom);
        map.addEventListener("mousedown", mousedown);
        map.addEventListener("mouseup", mouseup);
        map.addEventListener("mousemove", mousemove);
        map.addEventListener("ondrag", e => {e.preventDefault()});



        ///////////////////
        // Map dev tools //
        ///////////////////

        // There are dev elements, so we can detect dev tools now. [I don't care if this got spoofed lol]
        if (document.querySelector(".admin")) {
            const click_origin = document.querySelector(".click-origin"); // Set this to the top left origin point of the path
            const click_offset = document.querySelector(".click-offset"); // Set this to the amount of pixels it needs to be offset by (we will be saving this to the db)

            map.addEventListener("click", e => {
                let path = e.target;

                let mapBounds = svg_container.getBoundingClientRect();
                if (path.nodeName == "path") {
                    let relativePos = getRelativeToCountry(path);
                    click_origin.innerHTML = `Country origin [topleft]: <span class='copyable'> ${relativePos.x}px, ${relativePos.y}px </span>`;

                    let x = (e.clientX - mapBounds.x - relativePos.x); // / currentScale;
                    x = x.toFixed(2);
                    let y = (e.clientY - mapBounds.y - relativePos.y); // / currentScale;
                    y = y.toFixed(2);

                    let pathPercent = pxToPathPercent({x: x, y: y}, path);

                    click_offset.innerHTML = `[copy to db] Offset by: <span class='copyable'> ${pathPercent.x}, ${pathPercent.y} </span>`;
                }
            })
        }

    })
    .catch(error => {
        console.error("Error loading the SVG file:", error);
    })


