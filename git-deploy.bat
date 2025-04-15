@echo off
echo ---------------------------
echo Puxando alterações remotas
echo ---------------------------
git pull origin main

echo ---------------------------
echo Fazendo commit local
echo ---------------------------
git add .
git commit -m "Atualização local - main e dev"

echo ---------------------------
echo Enviando para main
echo ---------------------------
git push origin main

echo ---------------------------
echo Atualizando branch dev
echo ---------------------------
git checkout dev
git merge main
git push origin dev

echo ---------------------------
echo Voltando para main
echo ---------------------------
git checkout main

echo ✅ Finalizado com sucesso.
pause
