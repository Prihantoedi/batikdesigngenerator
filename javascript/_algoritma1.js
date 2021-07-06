    function batikCreate(widthCanv, heightCanv, paddingTop, paddingSide, obj, obj2, obj3, gap, gapX, gapY, clr1, clr2, clr3, isSave){
        
        // ** Ambil Nilai Warna, agar tidak berubah saat di scale
        firstColorVal = clr1;

        // Canvas SVG Element
        var hasilBatikCanv = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
        hasilBatikCanv.setAttribute("width"  , widthCanv  + "px");
        hasilBatikCanv.setAttribute("height" , heightCanv + "px");
        hasilBatikCanv.setAttribute("id"     , "svgBatik");
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
        let objScale    = obj/realObjSizex[0];

        // Ukuran motif relatif terhadap skalanya
        let objSizex    = realObjSizex[0]*objScale;
        let objSizey    = realObjSizey[0]*objScale;


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
        var gTrans = "scale(" + objScale +") " ;
        var kId = 0;

        // ** Tambah rectangle/canvas svg
        //  disini
        var myrect = document.createElementNS( "http://www.w3.org/2000/svg", 'rect');
        myrect.setAttribute("id", "mycanv");
        myrect.setAttribute("stroke", "black");
        myrect.setAttribute("stroke-width", "3");
        myrect.setAttribute("width",widthCanv);
        myrect.setAttribute("height",heightCanv);
        hasilBatikCanv.appendChild(myrect);

        // ** tambahan apabila output hitam putih di hal. simpanbatik
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

        // PENGISIAN MOTIF
        for (let i = 0; i < motifCol; i++) {
            for (let j = 0; j < motifRow; j++){
                // Coordinate
                let x = startx + i*objectnyax;
                let y = starty + j*objectnyay;
                let motif = motifPath[0];
                 // ** PERUBAHAN DI ARGUMEN, DITAMBAHI FIRSTCOLORVAL:
                motifCreate(x,y,gTrans, motif, firstColorVal);

                 // ** bila output hitam putih:
                if (isSave){motifCreate2(x,y,gTrans, motif);}
            }
        };

        // Append SVG ke halaman web
        document.getElementById("hasilBatik").appendChild(hasilBatikCanv);
        if (isSave){
            document.getElementById("hasilBatikHp").appendChild(hasilBatikCanv2);
        }

        function motifCreate(x, y, gTrans, motifPath, color){
            let gOuter = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gOuter.setAttribute("transform", "translate(" + x + " " + y + ")")
            
            let gInner = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gInner.setAttribute("transform", gTrans);
            gInner.appendChild(motifPath.cloneNode(true));          
            gInner.setAttribute("id", "mtf" + kId++);
            gInner.setAttribute("class", "first-motif");
            gInner.setAttribute("fill", color);
            gOuter.appendChild(gInner)
            hasilBatikCanv.appendChild(gOuter);
        }

        function motifCreate2(x, y, gTrans, motifPath){
            let gOuter = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gOuter.setAttribute("transform", "translate(" + x + " " + y + ")")
            
            let gInner = document.createElementNS("http://www.w3.org/2000/svg", "g");
            gInner.setAttribute("transform", gTrans);
            gInner.appendChild(motifPath.cloneNode(true));          
            gInner.setAttribute("id", "mtfHp" + kId++);
            gInner.setAttribute("class", "first-motif-hp");

            // ** penambahan attribute warna 1
            gInner.setAttribute("fill", "000");
            // gInner.setAttribute("fill", "red");

            gOuter.appendChild(gInner)
            hasilBatikCanv2.appendChild(gOuter);
        }


    }

