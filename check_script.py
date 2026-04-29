import os
with open('/Users/fryntiz/git/skeleton-laravel-project/Prompt Inicial.md') as f:
    text = f.read()
files = os.listdir('/Users/fryntiz/git/skeleton-laravel-project/docs/planning/fases/')
files.sort()
for file in files:
    print(file)
