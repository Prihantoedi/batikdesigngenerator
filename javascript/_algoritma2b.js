 
    // Canvas Dimension
    var width    = document.getElementById("width").value;
    var height   = document.getElementById("height").value;   
    // Motif Size
    var obj1   = document.getElementById("obj1").value;
    var obj2   = document.getElementById("obj2").value;
    var gap   = document.getElementById("gap").value;
    // Real Object 1 Size
    var realObjSizex1 = document.getElementById("svgmtf1").getAttribute("viewBox").split(" ")[2];
    var realObjSizey1 = document.getElementById("svgmtf1").getAttribute("viewBox").split(" ")[3];
    // Real Object 2 Size
    var realObjSizex2 = document.getElementById("svgmtf2").getAttribute("viewBox").split(" ")[2];
    var realObjSizey2 = document.getElementById("svgmtf2").getAttribute("viewBox").split(" ")[3];

    crtBatik(width, height, obj1, obj2, gap);
    

    

    var moveSlider = function(slider, variable) {
        var value = slider.value;
        if(variable == "width"){
            width = value;
        } else if(variable == "height"){
            height = value;
        } else if(variable == "obj1"){
            obj1 = value;
        } else if(variable == "obj2"){
            obj2 = value;
        } else if(variable == "gap"){
            gap = value;
        }
        
        document.getElementById("canv").innerHTML = "";
        crtBatik(width, height, obj1, obj2, gap);
    }

    var butChange = function(variable, change){
        let target
        if(variable == "width"){
            target = document.getElementById("width");
            target.value = parseInt(target.value) + change;
            width = target.value;
        } else if(variable == "height"){
            target = document.getElementById("height");
            target.value = parseInt(target.value) + change;
            height = target.value;
        } else if(variable == "obj1"){
            target = document.getElementById("obj1");
            target.value = parseInt(target.value) + change;
            obj1 = target.value;
        } else if(variable == "obj2"){
            target = document.getElementById("obj2");
            target.value = parseInt(target.value) + change;
            obj2 = target.value;
        } else if(variable == "gap"){
            target = document.getElementById("gap");
            target.value = parseInt(target.value) + change;
            gap = target.value;
        }

        
        document.getElementById("canv").innerHTML = "";
        crtBatik(width, height, obj1, obj2, gap);        
    }


    function crtBatik(widthCanv, heightCanv, Scale1, Scale2, objGap){
        var objScale1    = Scale1/100;
        var objScale2    = Scale2/100;

        var objSizex1    = realObjSizex1*objScale1;
        var objSizey1    = realObjSizey1*objScale1;
        var objectnyax = parseInt(objSizex1) + parseInt(objGap);
        var objectnyay = parseInt(objSizey1) + parseInt(objGap);

        var objSizex2    = realObjSizex2*objScale2
        var objSizey2    = realObjSizey2*objScale2

        // Column and Row Count
        var motifCol  = Math.floor(widthCanv/objectnyax);
        var motifRow  = Math.floor(heightCanv/objectnyay);

        // Padding
        var paddingx   = widthCanv  % objectnyax;
        var paddingy   = heightCanv % objectnyay;

        // Start Coordinate x and y
        var startx  = paddingx/2 + parseInt(objGap)/2;
        var starty  = paddingy/2 + parseInt(objGap)/2;



        // Canvas SVG Element
        var svgCanv = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
        svgCanv.setAttribute("width", widthCanv + "px");
        svgCanv.setAttribute("height", heightCanv + "px");
        svgCanv.setAttribute("id","svgBatik")

        // Element Motifnya 1
        var path1 = document.getElementById("pathC1A").getAttribute('d');
        var motif1 = document.createElementNS("http://www.w3.org/2000/svg", 'path');
        motif1.setAttribute("d", path1);

        // g element buat motif 1
        var gTrans = "scale(" + objScale1 +") " ;

        // Element Motifnya 2
        var path2 = document.getElementById("pathC1B").getAttribute('d');
        var motif2 = document.createElementNS("http://www.w3.org/2000/svg", 'path');
        motif2.setAttribute("d", path2);

        // g element buat motif 2
        var gTrans2 = "scale(" + objScale2 +") " ;


        // PENGISIAN PERTAMA
        var k = 0;
        for (let i = 0; i < motifCol; i++) {
            for (let j = 0; j < motifRow; j++){
                if(j%2){continue}

                // Coordinate for specific circle
                let x = startx + i*objectnyax ;
                let y = starty + j*objectnyay ;

                var g1 = document.createElementNS("http://www.w3.org/2000/svg", "g");
                g1.setAttribute("transform", "translate(" + x + " " + y + ")")
                
                var g = document.createElementNS("http://www.w3.org/2000/svg", "g");
                g.setAttribute("transform", gTrans);
                g.appendChild(motif1.cloneNode(true));          
                g.setAttribute("id", "mtf" + k++);
                
                g1.appendChild(g)
                svgCanv.appendChild(g1);
            }
        };

        // PENGISIAN KEDUA
        for (let i = 0; i < motifCol; i++) {
            for (let j = 0; j < motifRow; j++){
                if(!(j%2)){continue}

                // Coordinate for specific circle
                let x = startx + i*objectnyax - objSizex2/2 + objSizex1/2;
                let y = starty + j*objectnyay - objSizey2/2 + objSizex1/2;

                var g1 = document.createElementNS("http://www.w3.org/2000/svg", "g");
                g1.setAttribute("transform", "translate(" + x + " " + y + ")")
                
                var g = document.createElementNS("http://www.w3.org/2000/svg", "g");
                g.setAttribute("transform", gTrans2);
                g.appendChild(motif2.cloneNode(true));          
                g.setAttribute("id", "mtf" + k++);
                
                g1.appendChild(g)
                svgCanv.appendChild(g1);
            }
        };

        document.getElementById("canv").appendChild(svgCanv);
        document.getElementById("svgBatik").style.border = "solid black 2px";
        document.getElementById("svgBatik").style.padding= "10px";

    }

