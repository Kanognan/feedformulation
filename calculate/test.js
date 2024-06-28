resultElements.forEach((resultElement, index) => {
    const materialNameElement = resultElement.closest('tr').querySelector('.material-name');
    const materialName = materialNameElement.textContent.trim();
    materials.forEach((material) => {
        if (material.raw_thainame === materialName) {
            materialPrice = material.price;
        }
        if (material.ms_thainame === materialName) {
            materialPrice = mineral_sources.price;
        }
    });
    if (results.hasOwnProperty(materialName)) {
        const materialResult = results[materialName];
        resultElement.textContent = materialResult.toFixed(3);
        totalResult += materialResult;
        console.log(materialName, materialResult);

    } else {
        resultElement.closest('tr').style.display = 'none'
    }
});
resultElements.forEach((resultElement, index) => {
    const materialResult = parseFloat(resultElement.textContent.trim());
    const percent = (materialResult / totalResult) * 100;
    const showPercent = resultElement.closest('tr').querySelector('.percent');
    showPercent.textContent = percent.toFixed(3);

    const materialKG = percent / 100;
    const showMaterialKG = resultElement.closest('tr').querySelector('.materialKG');
    showMaterialKG.textContent = materialKG.toFixed(3);

    const showPriceElement = resultElement.closest('tr').querySelector('.show_price');
    if (!isNaN(materialPrice) && isFinite(materialPrice)) {
        const price = materialKG * materialPrice;
        showPriceElement.textContent = price.toFixed(3);
        if (!isNaN(price)) {
            resultKG += price;
            document.getElementById('result').textContent = resultKG.toFixed(3);
        }
    } else {
        console.log(`Invalid material price for ${materialName}`);
    }
    
});
document.getElementById("submit-button").addEventListener("click", function () {
    var values = {
        valuetotalTDN: totalTDN,
        valuetotalDE: totalDE,
        valuetotalME: totalME,
        valuetotalNEL: totalNEL,
        valuetotalCF: totalCF,
        valuetotalADF: totalADF,
        valuetotalNDF: totalNDF,
        valuetotalNFE: totalNFE,
        valuetotalCP: totalCP,
        valuetotalRUP: totalRUP,
        valuetotalLYS: totalLYS,
        valuetotalMET: totalMET,
        valuetotalCA: totalCA,
        valuetotalP: totalP,
        valuetotalVitaminA: totalVitaminA,
        valuetotalVitaminD: totalVitaminD,
        valuetotalVitaminE: totalVitaminE,
        valuetotalEE: totalEE
    };

    Object.keys(values).forEach(function (key) {
        document.getElementById(key).value = values[key];
    });

    document.getElementById("hidden-form").submit();
});