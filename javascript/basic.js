
    // Bikin motif pertama
    batikCreate(widthCanv, heightCanv, paddingTop, paddingSide, obj, obj2, obj3, gap, gapX, gapY, clr1, clr2, clr3, isSave);
    batikSizeAdj(isSave);

    // Perubahan nilai parameter
    function moveSlider(target, id){
        sValue = cmToPixel(target.value);  // nilai slider
        nilaiInputSimpan(sValue, id);

        document.getElementById("value-"+id).innerHTML = Math.round(pixelToCm(sValue));
        
        if(id == "widthCanv"){
            widthCanv = sValue;
        } else if(id == "heightCanv"){
            heightCanv = sValue;
        } else if(id == "padding-top"){
            paddingTop = sValue;
        } else if(id == "padding-side"){
            paddingSide = sValue;
        } else if(id == "obj"){
            obj = sValue;
        } else if(id == "obj2"){
            obj2 = sValue;
        } else if(id == "obj3"){
            obj3 = sValue;
        } else if(id == "gap"){
            gap = sValue;
        }  else if(id == "gapX"){
            gapX = sValue;
        } else if(id == "gapY"){
            gapY = sValue;
        } 
        document.getElementById("hasilBatik").innerHTML = "";
        clrBg = document.getElementById("color-canvas-opt").value;
        clr1 = document.getElementById("color-motif1-opt").value;
        clr2 = document.getElementById("color-motif2-opt").value;
        clr3 = document.getElementById("color-motif3-opt").value;

        batikCreate(widthCanv, heightCanv, paddingTop, paddingSide, obj, obj2, obj3, gap, gapX, gapY, clr1, clr2, clr3);
        var canvasColor = document.getElementById("colorbg").value;
        document.getElementById("mycanv").style.fill = canvasColor;
   
        batikSizeAdj();
    }

    function batikSizeAdj(save){
        let widthSVGActual  = widthCanv  * (screen.width - 300) / widthCanv;
        let heightSVGActual = heightCanv * (screen.width - 300) / widthCanv;
        
        document.getElementById("svgBatik").style.width = widthSVGActual  + "px";
        document.getElementById("svgBatik").style.height= heightSVGActual + "px";

        if (save){
            document.getElementById("svgBatik2").style.width = widthSVGActual  + "px";
            document.getElementById("svgBatik2").style.height= heightSVGActual + "px";
        }    
    }

    function nilaiInputSimpan(sValue, id){
        let varchange = document.getElementsByClassName("var_"+id);

        for(let i=0; i<varchange.length; i++) {
            varchange[i].value = Math.round(pixelToCm(sValue));
        }
    }