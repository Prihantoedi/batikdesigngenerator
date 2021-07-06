 
    // Canvas Dimension
    var width    = document.getElementById("width").value;
    var height   = document.getElementById("height").value;   
    // Motif Size
    var obj   = document.getElementById("obj").value;
    var gap   = document.getElementById("gap").value;
    // Real Object Size
    var realObjSizex = document.getElementById("svgmtf1").getAttribute("viewBox").split(" ")[2];
    var realObjSizey = document.getElementById("svgmtf1").getAttribute("viewBox").split(" ")[3];
    crtBatik(width, height, obj, gap);
    

    

    var moveSlider = function(slider, variable) {
        var value = slider.value;
        if(variable == "width"){
            width = value;
        } else if(variable == "height"){
            height = value;
        } else if(variable == "obj"){
            obj = value;
        } else if(variable == "gap"){
            gap = value;
        }
        
        document.getElementById("canv").innerHTML = "";
        crtBatik(width, height, obj, gap);
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
        } else if(variable == "obj"){
            target = document.getElementById("obj");
            target.value = parseInt(target.value) + change;
            obj = target.value;
        } else if(variable == "gap"){
            target = document.getElementById("gap");
            target.value = parseInt(target.value) + change;
            gap = target.value;
        }

        
        document.getElementById("canv").innerHTML = "";
        crtBatik(width, height, obj, gap);        
    }


    function crtBatik(widthCanv, heightCanv, Scale, objGap){
        var objScale    = Scale/200

        var objSizex    = realObjSizex*objScale
        var objSizey    = realObjSizey*objScale
        var objectnyax = parseInt(objSizex) + parseInt(objGap);
        var objectnyay = parseInt(objSizey) + parseInt(objGap);

        // Column and Row Count
        var motifCol  = Math.floor(widthCanv/objectnyax);
        var motifRow  = Math.floor(heightCanv/objectnyay);

        // Padding
        var paddingx   = widthCanv  % objectnyax;
        var paddingy   = heightCanv % objectnyay;

        // Start Coordinate x and y
        var startx  = widthCanv/2 - objectnyax/2;
        var starty  = heightCanv/2 - objectnyay/2;



        // Canvas SVG Element
        var svgCanv = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
        svgCanv.setAttribute("width", widthCanv + "px");
        svgCanv.setAttribute("height",heightCanv + "px");
        svgCanv.setAttribute("id","svgBatik")

        // Element Motifnya 1
        var path1 = document.getElementById("pathC1A").getAttribute('d');
        var motif1 = document.createElementNS("http://www.w3.org/2000/svg", 'path');
        motif1.setAttribute("d", path1);

        // g element buat motif 1
        var gTrans = "scale(" + objScale +") " ;



        // PENGISIAN SPIRAL
        var kId = 0;
        var x = startx;
        var y = starty;
        var LapisanMotif;

        if (widthCanv<heightCanv){
            LapisanMotif = motifRow/2
        } else{
            LapisanMotif = motifCol/2;
        } 

        function createMotif(x,y,gTrans){
        var g1 = document.createElementNS("http://www.w3.org/2000/svg", "g");
        g1.setAttribute("transform", "translate(" + x + " " + y + ")")
        
        var g = document.createElementNS("http://www.w3.org/2000/svg", "g");
        g.setAttribute("transform", gTrans);
        g.appendChild(motif1.cloneNode(true));          
        g.setAttribute("id", "mtf" + kId++);
        
        g1.appendChild(g)
        svgCanv.appendChild(g1);
        }

        createMotif(x,y,gTrans);


        for(let i = 1; i < 5; i++ ){
            var k = i*3;

            
            y = y - 3*objectnyay;
            for(let ij = 0; ij < 4; ij++){
                for( let j = 0; j < k; j++){
                    createMotif(x,y,gTrans);
                    if(ij<2){m = 1} 
                    else{m = -1};
                    if(ij<=2 & ij>0){n = 1} 
                    else{n = -1};
                    x = x + n*objectnyax;
                    y = y + m*objectnyay;
                }
            }
        }
        
        document.getElementById("canv").appendChild(svgCanv);
        document.getElementById("svgBatik").style.border = "solid black 2px";
        document.getElementById("svgBatik").style.padding= "5px";

    }

