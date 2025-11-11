
$(document).ready(function () {

    // --- Hover Effect (Tooltip) ---
    const tooltip = $('#tooltip');

    $('#nepal-map path').on({
        mouseenter: function (e) {
            const districtName = $(this).data('name');
            if (districtName) {
                tooltip.text(districtName).show();
            }
        },
        mousemove: function (e) {
            // Position the tooltip near the cursor
            tooltip.css({
                'left': e.pageX + 10,
                'top': e.pageY + 10
            });
        },
        mouseleave: function () {
            tooltip.hide();
        }
    });

    // --- Click Event (Modal) ---
    $('#nepal-map path').on('click', function () {
        const districtName = $(this).data('name');
        $('#amd-modal-title').text(districtName); // Set amd-modal title
        $('#myModal').show(); // Show the amd-modal
    });

    // Close the amd-modal
    $('.amd-close-button').on('click', function () {
        $('#myModal').hide();
    });

    // Close amd-modal when clicking outside of it
    $(window).on('click', function (event) {
        if ($(event.target).is('#myModal')) {
            $('#myModal').hide();
        }
    });

    // --- Zoom Functionality ---
    let scale = 1;
    const scaleFactor = 1.2;
    const maxScale = 3;
    const minScale = 1;

    // Zoom In
    $('.zoom-in').on('click', function () {
        scale = Math.min(scale * scaleFactor, maxScale);
        $('#nepal-map').css('transform', `scale(${scale})`);
    });

    // Zoom Out
    $('.zoom-out').on('click', function () {
        scale = Math.max(scale / scaleFactor, minScale);
        $('#nepal-map').css('transform', `scale(${scale})`);
    });
});


const tooltip = document.getElementById("map-tooltip");
const districtCard = document.getElementById("district-card");
const districtName = districtCard.querySelector("h4");
const districtDetails = districtCard.querySelector("p");

// Nepal 77 districts with example data
const districts = {
    1: { name: " Jhapa", details: "Population: 127,461 | Schools: 40 | Projects: 5", icon: "📍" },
    2: { name: "Panchthar", details: "Population: 191,817 | Schools: 35 | Projects: 4", icon: "📍" },
    3: { name: "Ilam", details: "Population: 290,254 | Schools: 50 | Projects: 6", icon: "📍" },
    4: { name: "Taplejung", details: "Population: 812,650 | Schools: 70 | Projects: 8", icon: "📍" },
    5: { name: "Morang", details: "Population: 965,370 | Schools: 80 | Projects: 10", icon: "📍" },
    6: { name: "Sunsari", details: "Population: 763,487 | Schools: 65 | Projects: 7", icon: "📍" },
    7: { name: "Dhankuta", details: "Population: 163,412 | Schools: 25 | Projects: 3", icon: "📍" },
    8: { name: "Terhathum", details: "Population: 102,009 | Schools: 20 | Projects: 2", icon: "📍" },
    9: { name: "Bhojpur", details: "Population: 182,459 | Schools: 30 | Projects: 4", icon: "📍" },
    10: { name: "Sankhuwasabha", details: "Population: 158,742 | Schools: 22 | Projects: 3", icon: "📍" },
    11: { name: " Udayapur", details: "Population: 105,886 | Schools: 18 | Projects: 2", icon: "📍" },
    12: { name: "Khotang", details: "Population: 147,984 | Schools: 20 | Projects: 2", icon: "📍" },
    13: { name: " Okhaldhunga", details: "Population: 206,312 | Schools: 25 | Projects: 3", icon: "📍" },
    14: { name: "Solukhumbu", details: "Population: 317,532 | Schools: 40 | Projects: 4", icon: "📍" },
    15: { name: "Saptari", details: "Population: 637,328 | Schools: 50 | Projects: 5", icon: "📍" },
    16: { name: " Siraha", details: "Population: 639,284 | Schools: 50 | Projects: 5", icon: "📍" },
    17: { name: "Dhanusha", details: "Population: 754,777 | Schools: 60 | Projects: 6", icon: "📍" },
    18: { name: "Mahottari", details: "Population: 627,580 | Schools: 55 | Projects: 5", icon: "📍" },
    19: { name: "Sarlahi", details: "Population: 769,729 | Schools: 60 | Projects: 6", icon: "📍" },
    20: { name: "Bara ", details: "Population: 296,192 | Schools: 35 | Projects: 3", icon: "📍" },
    21: { name: " Parsa", details: "Population: 202,646 | Schools: 30 | Projects: 2", icon: "📍" },
    22: { name: "Rautahat ", details: "Population: 186,557 | Schools: 25 | Projects: 2", icon: "📍" },
    23: { name: "Sindhuli", details: "Population: 287,798 | Schools: 40 | Projects: 4", icon: "📍" },
    24: { name: "Ramechhap", details: "Population: 381,937 | Schools: 45 | Projects: 5", icon: "📍" },
    25: { name: " Dolakha", details: "Population: 481,936 | Schools: 55 | Projects: 6", icon: "📍" },
    26: { name: "Bhaktapur", details: "Population: 304,651 | Schools: 35 | Projects: 4", icon: "📍" },
    27: { name: "  Dhading", details: "Population: 1,744,240 | Schools: 100 | Projects: 10", icon: "📍" },
    28: { name: "  Kathmandu", details: "Population: 277,471 | Schools: 35 | Projects: 4", icon: "📍" },
    29: { name: " Kavrepalanchok", details: "Population: 43,300 | Schools: 15 | Projects: 2", icon: "📍" },
    30: { name: "Lalitpur", details: "Population: 336,067 | Schools: 40 | Projects: 4", icon: "📍" },
    31: { name: " Nuwakot", details: "Population: 420,477 | Schools: 50 | Projects: 5", icon: "📍" },
    32: { name: " Rasuwa", details: "Population: 686,722 | Schools: 55 | Projects: 5", icon: "📍" },
    33: { name: " Sindhupalchok", details: "Population: 687,708 | Schools: 60 | Projects: 6", icon: "📍" },
    34: { name: "Chitwan", details: "Population: 601,017 | Schools: 50 | Projects: 5", icon: "📍" },
    35: { name: "  Makwanpur", details: "Population: 579,984 | Schools: 55 | Projects: 6", icon: "📍" },
    36: { name: "Gorkha", details: "Population: 271,061 | Schools: 35 | Projects: 3", icon: "📍" },
    37: { name: "Kaski", details: "Population: 167,724 | Schools: 30 | Projects: 2", icon: "📍" },
    38: { name: " Lamjung", details: "Population: 323,288 | Schools: 40 | Projects: 4", icon: "📍" },
    39: { name: "Syangja", details: "Population: 289,148 | Schools: 35 | Projects: 3", icon: "📍" },
    40: { name: " Tanahu", details: "Population: 492,098 | Schools: 60 | Projects: 6", icon: "📍" },
    41: { name: "Manang", details: "Population: 6,538 | Schools: 5 | Projects: 1", icon: "📍" },
    42: { name: "Newalparasi", details: "Population: 13,452 | Schools: 8 | Projects: 2", icon: "📍" },
    43: { name: " Baglung", details: "Population: 114,509 | Schools: 20 | Projects: 2", icon: "📍" },
    44: { name: " Myagdi", details: "Population: 146,590 | Schools: 25 | Projects: 3", icon: "📍" },
    45: { name: " Parbat", details: "Population: 268,613 | Schools: 30 | Projects: 3", icon: "📍" },
    46: { name: " Mustang", details: "Population: 280,160 | Schools: 30 | Projects: 3", icon: "📍" },
    47: { name: "Kapilbastu", details: "Population: 261,180 | Schools: 30 | Projects: 3", icon: "📍" },
    48: { name: "Nawalpur", details: "Population: 310,864 | Schools: 35 | Projects: 4", icon: "📍" },
    49: { name: "Rupandehi", details: "Population: 880,196 | Schools: 60 | Projects: 6", icon: "📍" },
    50: { name: "Arghakhanchi", details: "Population: 571,936 | Schools: 55 | Projects: 5", icon: "📍" },
    51: { name: " Gulmi" , details: "Population: 197,632 | Schools: 25 | Projects: 2", icon: "📍" },
    52: { name: "Palpa", details: "Population: 228,102 | Schools: 25 | Projects: 2", icon: "📍" },
    53: { name: "Dang", details: "Population: 205,937 | Schools: 25 | Projects: 2", icon: "📍" },
    54: { name: "Pyuthan ", details: "Population: 165,242 | Schools: 20 | Projects: 2", icon: "📍" },
    55: { name: "Rolpa", details: "Population: 155,566 | Schools: 20 | Projects: 2", icon: "📍" },
    56: { name: "Rukum", details: "Population: 242,444 | Schools: 25 | Projects: 2", icon: "📍" },
    57: { name: "Banke", details: "Population: 553,481 | Schools: 45 | Projects: 4", icon: "📍" },
    58: { name: " Bardiya", details: "Population: 382,649 | Schools: 35 | Projects: 3", icon: "📍" },
    59: { name: "Rukum", details: "Population: 426,576 | Schools: 40 | Projects: 4", icon: "📍" },
    60: { name: "Salyan", details: "Population: 350,804 | Schools: 30 | Projects: 3", icon: "📍" },
    61: { name: "Dolpa", details: "Population: 261,770 | Schools: 25 | Projects: 2", icon: "📍" },
    62: { name: "Humla", details: "Population: 171,304 | Schools: 20 | Projects: 2", icon: "📍" },
    63: { name: "Jumla", details: "Population: 36,700 | Schools: 10 | Projects: 1", icon: "📍" },
    64: { name: "Kalikot", details: "Population: 55,286 | Schools: 15 | Projects: 1", icon: "📍" },
    65: { name: "Mugu", details: "Population: 50,858 | Schools: 12 | Projects: 1", icon: "📍" },
    66: { name: "Surkhet", details: "Population: 108,921 | Schools: 20 | Projects: 2", icon: "📍" },
    67: { name: "Dailekh", details: "Population: 136,948 | Schools: 25 | Projects: 2", icon: "📍" },
    68: { name: "Jajarkot", details: "Population: 134,199 | Schools: 20 | Projects: 2", icon: "📍" },
    69: { name: "Kailali", details: "Population: 182,136 | Schools: 25 | Projects: 2", icon: "📍" },
    70: { name: "Achham", details: "Population: 133,274 | Schools: 20 | Projects: 2", icon: "📍" },
    71: { name: " Doti", details: "Population: 250,898 | Schools: 25 | Projects: 2", icon: "📍" },
    72: { name: "Bajhang", details: "Population: 142,094 | Schools: 20 | Projects: 2", icon: "📍" },
    73: { name: "Bajura", details: "Population: 171,304 | Schools: 25 | Projects: 2", icon: "📍" },
    74: { name: "Kanchanpur", details: "Population: 775,709 | Schools: 45 | Projects: 4", icon: "📍" },
    75: { name: " Dadeldhura", details: "Population: 257,477 | Schools: 25 | Projects: 2", icon: "📍" },
    76: { name: "Baitadi", details: "Population: 211,746 | Schools: 20 | Projects: 2", icon: "📍" },
    77: { name: "Darchula", details: "Population: 182,136 | Schools: 25 | Projects: 2", icon: "📍" }
};


// Hover for tooltip + card update
document.querySelectorAll("#nepal-map path").forEach(path => {
    path.addEventListener("mousemove", e => {
        const district = districts[path.id];
        if (district) {
            // Tooltip only shows name
            tooltip.innerText = district.name;
            tooltip.style.display = "block";
            tooltip.style.left = e.pageX + 15 + "px";
            tooltip.style.top = e.pageY + 15 + "px";

            // Update card content
            districtName.innerText = district.name;
            districtDetails.innerText = district.details;
        }
    });

    path.addEventListener("mouseleave", () => {
        tooltip.style.display = "none";
    });
});
