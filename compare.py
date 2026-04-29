with open('/Users/fryntiz/git/skeleton-laravel-project/Prompt Inicial.md') as f:
    prompt = f.read()
import re
# find all requirements in the prompt
# This is hard to automate perfectly, let's extract things that were asked but not found in the output.
import json
