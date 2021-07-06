    function batikCreate(widthCanv, heightCanv, paddingTop, paddingSide, obj, obj2, obj3, gap, gapX, gapY, clr1, clr2, clr3, isSave){
         // handling perubahan warna
         clrChange[1] = "1";
         var ccClass = document.getElementsByClassName("color_change");
         for(var c = 0; c < ccClass.length ; c++){
             ccClass[c].setAttribute("value", clrChange);
            
         }
        var firstColorVal = clr1;
        var secondColorVal = clr2;
        var thirdColorVal = clr3;

        // Canvas SVG Element
        var hasilBatikCanv = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
        hasilBatikCanv.setAttribute("width", widthCanv + "px");
        hasilBatikCanv.setAttribute("height",heightCanv + "px");
        hasilBatikCanv.setAttribute("id","svgBatik");
        hasilBatikCanv.setAttribute("viewBox", "0 0 " + widthCanv + " " + heightCanv);
        
        // Ukuran asli motif
        for(let i = 0; i < motifJml; i++){
            realObjSizex.push(motifTagHTML[i].getAttribute("viewBox").split(" ")[2]);
            realObjSizey.push(motifTagHTML[i].getAttribute("viewBox").split(" ")[3]);
        }
        
        // Path motifnya
        for(let i = 0; i < motifJml; i++){
            let path   = motifTagHTML[i].getElementsByTagName("path")[0].getAttribute("d");  // kalau svg nya bukan yang standar bikin mungkn children bukan indeks 2
            let motif  = document.createElementNS("http://www.w3.org/2000/svg", 'path');
            motif.setAttribute("d", path);
            
            motifPath.push(motif);
        }

        // Skala ukuran motif
        let objScale    = obj  / realObjSizex[0];
        let objScale2   = obj2 / realObjSizex[0];
        let objScale3   = obj3 / realObjSizex[0];
        
        // Ukuran motif relatif terhadap skalanya
        let objSizex    = realObjSizex[0]*objScale;
        let objSizey    = realObjSizey[0]*objScale;
        let objSizex2   = realObjSizex[1]*objScale2;
        let objSizey2   = realObjSizey[1]*objScale2;
        let objSizex3   = realObjSizex[2]*objScale3;
        let objSizey3   = realObjSizey[2]*objScale3;

        // Ukuran motif ditambah dengan jarak
        let objectnyax = parseInt(objSizex) + parseInt(gap) + parseInt(gapX);
        let objectnyay = parseInt(objSizey) + parseInt(gap) + parseInt(gapY);

        // Jumlah Column and Row motifnya
        let motifCol  = Math.floor((widthCanv  - paddingSide)  /objectnyax);
        let motifRow  = Math.floor((heightCanv - paddingTop) /objectnyay);

        // Padding
        let paddingx   = (widthCanv  - paddingSide)  % objectnyax ;
        let paddingy   = (heightCanv - paddingTop) % objectnyay ;

        // Start Coordinate x and y
        let startx  = paddingx/2 + parseInt(gap)/2 + paddingSide/2 + gapX/2;
        let starty  = paddingy/2 + parseInt(gap)/2 + paddingTop/2  + gapY/2;

        // g element buat motif 1
        var gTrans  = "scale(" + objScale  +") " ;
        var gTrans2 = "scale(" + objScale2 +") " ; 
        var gTrans3 = "scale(" + objScale3 +") " ; 
        var kId = 0; // Id motif

        // buat kanvas svg
        var myrect = document.createElementNS( "http://www.w3.org/2000/svg", 'rect');
        myrect.setAttribute("id", "mycanv");
        myrect.setAttribute("stroke", "black");
        myrect.setAttribute("stroke-width", "3");
        myrect.setAttribute("width",widthCanv);
        myrect.setAttribute("height",heightCanv);
        hasilBatikCanv.appendChild(myrect);

        // tambahan apabila output hitam putih di hal. simpanbatik
        if (isSave){
                // Canvas SVG Element
            var hasilBatikCanv2 = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
            hasilBatikCanv2.setAttribute("width"  , widthCanv  + "px");
            hasilBatikCanv2.setAttribute("height" , heightCanv + "px");
            hasilBatikCanv2.setAttribute("id"     , "svgBatik2");
            hasilBatikCanv2.setAttribute("viewBox", "0 0 " + widthCanv + " " + heightCanv);

            var myrect2 = document.createElementNS( "http://www.w3.org/2000/svg", 'rect');
            myrect2.setAttribute("id", "mycanv2");
            myrect2.setAttribute("stroke", "black");
            myrect2.setAttribute("stroke-width", "3");
            myrect2.setAttribute("width",widthCanv);
            myrect2.setAttribute("height",heightCanv);
            myrect2.setAttribute("fill", "#fff");
            hasilBatikCanv2.appendChild(myrect2);
        }

 
         // tambahan apabila output hitam putih di hal. simpanbatik
         if (isSave){
                 // Canvas SVG Element
             var hasilBatikCanv2 = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
             hasilBatikCanv2.setAttribute("width"  , widthCanv  + "px");
             hasilBatikCanv2.setAttribute("height" , heightCanv + "px");
             hasilBatikCanv2.setAttribute("id"     , "svgBatik2");
             hasilBatikCanv2.setAttribute("viewBox", "0 0 " + widthCanv + " " + heightCanv);
 
             var myrect2 = document.createElementNS( "http://www.w3.org/2000/svg", 'rect');
             myrect2.setAttribute("id", "mycanv2");
             myrect2.setAttribute("stroke", "black");
             myrect2.setAttribute("stroke-width", "3");
             myrect2.setAttribute("width",widthCanv);
             myrect2.setAttribute("height",heightCanv);
             myrect2.setAttribute("fill", "#fff");
             hasilBatikCanv2.appendChild(myrect2);
         }
        // PENGISIAN MOTIF PERTAMA
        for (let i = 0; i < motifCol; i++) {
            for (let j = 0; j < motifRow; j++){
                if((i+j)%2){continue}

                // Coordinate for specific circle
                let x = startx + i*objectnyax ;
                let y = starty + j*objectnyay ;
                let motif = motifPath[0];
                //** Fungsi untuk menggambar dan mewarnai motif 1 
                firstMotifCreate(x,y,gTrans2, motif, firstColorVal);

                // pengecekkan halaman simpanbatik
                if(isSave){motifCreateHp(x,y,gTrans2, motif);}
            }
        };

        // PENGISIAN MOTIF KEDUA
        for (let i = 0; i < motifCol; i++) {
            for (let j = 0; j < motifRow; j++){
                if(!((i+j)%2) | !(i%2)){continue}

                // Coordinate for specific circle
                let x = startx + i*objectnyax - objSizex2/2 + objSizex/2;
                let y = starty + j*objectnyay - objSizey2/2 + objSizey/2;
                let motif = motifPath[1];
                //** Fungsi untuk menggambar dan mewarnai motif 2
                secondMotifCreate(x,y,gTrans2, motif, secondColorVal);

                // pengecekkan halaman simpanbatik
                if(isSave){motifCreateHp(x,y,gTrans2, motif);}
            }
        };

        // PENGISIAN MOTIF KETIGA
        for (let i = 0; i < motifCol; i++) {
            for (let j = 0; j < motifRow; j++){
                if((!((i+j)%2)) | (i%2)){continue}

                // Coordinate for specific circle
                let x = startx + i*objectnyax - objSizex3/2 + objSizex/2;
                let y = starty + j*objectnyay - objSizey3/2 + objSizey/2;
                let motif = motifPath[2];
                 //** Fungsi untuk menggambar dan mewarnai motif 3
                 thirdMotifCreate(x,y,gTrans2, motif, thirdColorVal);

                 // pengecekkan halaman simpanbatik
                 if(isSave){motifCreateHp(x,y,gTrans2, motif);}
            }
        };

        // Append SVG ke halaman web
        document.getElementById("hasilBatik").appendChild(hasilBatikCanv);
        if (isSave){
            document.getElementById("hasilBatikHp").appendChild(hasilBatikCanv2);
        }

        function firstMotifCreate(x, y, gTrans, motifPath, color){
            let gOuter = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gOuter.setAttribute("transform", "translate(" + x + " " + y + ")")
            
            let gInner = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gInner.setAttribute("transform", gTrans);
            gInner.appendChild(motifPath.cloneNode(true));          
            gInner.setAttribute("id", "mtf" + kId++);
            gInner.setAttribute("class", "first-motif");

            // ** penambahan attribute warna 1
            gInner.setAttribute("fill", color);

            gOuter.appendChild(gInner)
            hasilBatikCanv.appendChild(gOuter);
        }

        // MOTIF 2
        function secondMotifCreate(x, y, gTrans, motifPath, color){
            let gOuter = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gOuter.setAttribute("transform", "translate(" + x + " " + y + ")")
            
            let gInner = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gInner.setAttribute("transform", gTrans);
            gInner.appendChild(motifPath.cloneNode(true));          
            gInner.setAttribute("id", "mtf" + kId++);
            gInner.setAttribute("class", "second-motif");

            // ** penambahan attribute warna 2
            gInner.setAttribute("fill", color);

            gOuter.appendChild(gInner)
            hasilBatikCanv.appendChild(gOuter);
        }

        // MOTIF 3
        function thirdMotifCreate(x, y, gTrans, motifPath, color){
            let gOuter = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gOuter.setAttribute("transform", "translate(" + x + " " + y + ")")
            
            let gInner = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gInner.setAttribute("transform", gTrans);
            gInner.appendChild(motifPath.cloneNode(true));          
            gInner.setAttribute("id", "mtf" + kId++);
            gInner.setAttribute("class", "third-motif");

            // ** penambahan attribute warna 3
            gInner.setAttribute("fill", color);

            gOuter.appendChild(gInner);
            hasilBatikCanv.appendChild(gOuter);
        }

        function motifCreateHp(x, y, gTrans, motifPath, color){
            let gOuter = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gOuter.setAttribute("transform", "translate(" + x + " " + y + ")")
            
            let gInner = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gInner.setAttribute("transform", gTrans);
            gInner.appendChild(motifPath.cloneNode(true));          
            gInner.setAttribute("id", "mtf" + kId++);
            // gInner.setAttribute("class", "first-motif-hp");

            // ** penambahan attribute warna 1
            gInner.setAttribute("fill", "000");
            // gInner.setAttribute("fill", "red");

            gOuter.appendChild(gInner)
            hasilBatikCanv2.appendChild(gOuter);
        }
    }