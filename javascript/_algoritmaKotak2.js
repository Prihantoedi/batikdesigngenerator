function batikCreate(widthCanv, heightCanv, paddingTop, paddingSide, obj, obj2, obj3, gap, gapX, gapY, clr1, clr2, clr3, isSave){
   
    clrChange[0] = "1";
    var ccClass = document.getElementsByClassName("color_change");
    for(var c = 0; c < ccClass.length ; c++){
        ccClass[c].setAttribute("value", clrChange);

    }
    var firstColorVal = clr1;
    var secondColorVal = clr2;    
    
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

    // Start Coordinate x and y
    let startx  = widthCanv/2  - objectnyax/2 + parseInt(gap)/2 + gapX/2;
    let starty  = heightCanv/2 - objectnyay/2 + parseInt(gap)/2 + gapY/2;

    // g element buat motif 1
    let gTrans  = "scale(" + objScale  +") " ;
    let gTrans2 = "scale(" + objScale2 +") " ; 
    // let gTrans3 = "scale(" + objScale3 +") " ; 
    let kId = 0;

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

    // PENGISIAN KOTAK MOTIF PERTAMA
    let x = startx;
    let y = starty;
    let LapisanMotif;
    let motif = motifPath[0];

    if ( (widthCanv - paddingSide) > (heightCanv - paddingTop) ){
        LapisanMotif = Math.ceil( ( ((widthCanv - paddingSide) / objectnyax) - 1 ) / 4 );
    } else{
        LapisanMotif = Math.ceil( ( ((heightCanv - paddingTop) / objectnyay) - 1 ) / 4 );
    } 

    
    
    // Iterasi Motif Kotak
    firstMotifCreate(x,y,gTrans, motif, firstColorVal);
    if (isSave){motifCreateHp(x,y,gTrans, motif);}

    for(let i = 1; i <= LapisanMotif; i++ ){
            let MotifJmlSisi = i*4;
            x = x - objectnyax*2;
            y = y - objectnyay*2;

            for( let j = 0; j < MotifJmlSisi; j++){
                if( x < paddingSide/2 ||
                    y < paddingTop/2  ||
                    x > widthCanv   - paddingSide/2 - objectnyax +1.5|| 
                    y > heightCanv  - paddingTop/2 - objectnyay  +1.5
                ){x = x + objectnyax; continue}
                // Iterasi Motif Kotak
                firstMotifCreate(x,y,gTrans, motif, firstColorVal);
                if (isSave){motifCreateHp(x,y,gTrans, motif);}
                    x = x + objectnyax;
            }
            for( let j = 0; j < MotifJmlSisi; j++){
                if( x < paddingSide/2 ||
                    y < paddingTop/2  ||
                    x > widthCanv   - paddingSide/2 - objectnyax +1.5|| 
                    y > heightCanv  - paddingTop/2 - objectnyay  +1.5
                ){y = y + objectnyay; continue}

                firstMotifCreate(x,y,gTrans, motif, firstColorVal);
                if (isSave){motifCreateHp(x,y,gTrans, motif);}
                    y = y + objectnyay;
            }
            for( let j = 0; j < MotifJmlSisi; j++){
                if( x < paddingSide/2 ||
                    y < paddingTop/2  ||
                    x > widthCanv   - paddingSide/2 - objectnyax +1.5|| 
                    y > heightCanv  - paddingTop/2 - objectnyay  +1.5
                ){x = x - objectnyax; continue}
                firstMotifCreate(x,y,gTrans, motif, firstColorVal);
                if (isSave){motifCreateHp(x,y,gTrans, motif);}
                x = x - objectnyax;
            }
            for( let j = 0; j < MotifJmlSisi; j++){
                if( x < paddingSide/2 ||
                    y < paddingTop/2  ||
                    x > widthCanv   - paddingSide/2 - objectnyax +1.5|| 
                    y > heightCanv  - paddingTop/2 - objectnyay  +1.5
                ){y = y - objectnyay; continue}
                
                firstMotifCreate(x,y,gTrans, motif, firstColorVal);
                if (isSave){motifCreateHp(x,y,gTrans, motif);}
                y = y - objectnyay;
            }
        }

    // PENGISIAN KOTAK MOTIF KEDUA
    x = startx - objectnyax;
    y = starty - objectnyay;
    motif = motifPath[1];

    
    // Iterasi Motif Kotak
        for(let i = 0; i <= LapisanMotif; i++ ){
            let MotifJmlSisi = 2 + i*4
            
            if(i == 0){
                x = x + (objSizex-objSizex2)/2;
                y = y + (objSizey-objSizey2)/2;
            }

            for( let j = 0; j < MotifJmlSisi; j++){
                if( x < paddingSide/2 ||
                    y < paddingTop/2  ||
                    x > widthCanv   - paddingSide/2 - objectnyax +1.5|| 
                    y > heightCanv  - paddingTop/2 - objectnyay  +1.5
                ){x = x + objectnyax; continue}
                secondMotifCreate(x,y,gTrans2, motif, secondColorVal);
                if (isSave){motifCreateHp(x,y,gTrans, motif);}
                x = x + objectnyax;
            }
            
            for( let j = 0; j < MotifJmlSisi; j++){
                if( x < paddingSide/2 ||
                    y < paddingTop/2  ||
                    x > widthCanv   - paddingSide/2 - objectnyax +1.5|| 
                    y > heightCanv  - paddingTop/2 - objectnyay  +1.5
                ){y = y + objectnyay; continue}
                secondMotifCreate(x,y,gTrans2, motif, secondColorVal);
                if (isSave){motifCreateHp(x,y,gTrans, motif);}
                y = y + objectnyay;
            }
            
            for( let j = 0; j < MotifJmlSisi; j++){
                if( x < paddingSide/2 ||
                    y < paddingTop/2  ||
                    x > widthCanv   - paddingSide/2 - objectnyax +1.5|| 
                    y > heightCanv  - paddingTop/2 - objectnyay  +1.5
                ){x = x - objectnyax; continue}
                secondMotifCreate(x,y,gTrans2, motif, secondColorVal);
                if (isSave){motifCreateHp(x,y,gTrans, motif);}
                x = x - objectnyax;
            }
            
            for( let j = 0; j < MotifJmlSisi; j++){
                if( x < paddingSide/2 ||
                    y < paddingTop/2  ||
                    x > widthCanv   - paddingSide/2 - objectnyax +1.5|| 
                    y > heightCanv  - paddingTop/2 - objectnyay  +1.5
                ){y = y - objectnyay; continue}
                secondMotifCreate(x,y,gTrans2, motif, secondColorVal);
                if (isSave){motifCreateHp(x,y,gTrans, motif);}
                y = y - objectnyay;
            }
            x = x - objectnyax*2;
            y = y - objectnyay*2;
        }

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

    function motifCreateHp(x, y, gTrans, motifPath){
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

    
    