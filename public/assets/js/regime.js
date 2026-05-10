/* ==========================================================
   REGIME JS — regime.js
   Estimate calculations, objective status for regime show page.
   ========================================================== */

(function () {
  'use strict';

  var form = document.getElementById('commande-form');
  if (!form) return;

  var objectiveStatus = document.getElementById('objectif-status');
  var objectiveStatusFail = document.getElementById('objectif-status-fail');

  // Data injected from controller in the view
  var variationMonthly = window.regimeData ? window.regimeData.variationMonthly : 0;
  var user = window.regimeData ? window.regimeData.user : null;
  var imcIdealMin = window.regimeData ? window.regimeData.imcIdealMin : null;
  var imcIdealMax = window.regimeData ? window.regimeData.imcIdealMax : null;

  function formatKg(value) {
    var sign = value > 0 ? '+' : '';
    var formatted = value.toFixed(2).replace(/\.00$/, '').replace(/\.([1-9])0$/, '.$1');
    return sign + formatted + 'kg';
  }

  function updateEstimates() {
    var estimateNodes = form.querySelectorAll('.estimate');
    estimateNodes.forEach(function (node) {
      var days = Number(node.dataset.days || 0);
      var estimated = variationMonthly * (days / 30);
      node.textContent = formatKg(estimated);
    });
  }

  function isObjectiveReached(selectedDays) {
    if (!user) return false;

    var variation = variationMonthly * (selectedDays / 30);
    var poidsActuel = Number(user.poids_kg || 0);
    var poidsObjectif = user.poids_objectif !== null ? Number(user.poids_objectif) : null;
    var tailleCm = Number(user.taille_cm || 0);
    var objectifId = Number(user.id_objectif || 0);

    if (objectifId === 1 && poidsObjectif !== null) {
      var cible = poidsObjectif - poidsActuel;
      return variation <= cible;
    }

    if (objectifId === 2 && poidsObjectif !== null) {
      var cible2 = poidsObjectif - poidsActuel;
      return variation >= cible2;
    }

    if (objectifId === 3 && tailleCm > 0 && imcIdealMin !== null && imcIdealMax !== null) {
      var tailleM = tailleCm / 100;
      var nouveauPoids = poidsActuel + variation;
      var imc = nouveauPoids / (tailleM * tailleM);
      return imc >= imcIdealMin && imc <= imcIdealMax;
    }

    return false;
  }

  function updateObjectiveStatus() {
    var selected = form.querySelector('input[name="id_duree_regime"]:checked');
    if (!selected) return;

    var days = Number(selected.dataset.days || 0);

    if (!user) {
      if (objectiveStatus) objectiveStatus.style.display = 'none';
      if (objectiveStatusFail) objectiveStatusFail.style.display = 'none';
      return;
    }

    var reached = isObjectiveReached(days);
    if (objectiveStatus) objectiveStatus.style.display = reached ? 'block' : 'none';
    if (objectiveStatusFail) objectiveStatusFail.style.display = reached ? 'none' : 'block';
  }

  updateEstimates();
  updateObjectiveStatus();
  form.addEventListener('change', updateObjectiveStatus);
})();
