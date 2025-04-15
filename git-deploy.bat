:: 1. Garante que está na main
git checkout main

:: 2. Adiciona tudo e comita na main
git add .
git commit -m "Atualização na main"

:: 3. Sobe a main
git push origin main

:: 4. Vai para dev e atualiza com base na main
git checkout dev
git pull origin dev
git merge main
git push origin dev

:: 5. Vai para geinian e atualiza com base na dev
git checkout geinian
git pull origin geinian
git merge dev
git push origin geinian

:: 6. Volta pra main
git checkout main
