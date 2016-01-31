            
function findInnerElement(startE, i)   {
                if(startE.childNodes.length == 0)   {
                    return {"E":startE, "iteration":i};
                }
                //beyond this point, startE has children nodes
                var inners = [];
                for(i = 0; i < startE.childNodes.length; i++)   {
                    inners.push(findInnerElement(startE.childNodes[i], i + 1));
                }
                //array inners should have the inner elements of each of startE's child nodes
                //now compare the iteration values of each child node
                var maxIteration = 0;
                var maxEpair;
                for(j = 0; j < inners.length; j++)  {
                    if(inners[j].iteration > maxIteration)  {
                        maxIteration = inners[j].iteration;
                        maxEpair = inners[j];
                    }
                }
                //the max E, iteration pair should now be found
                
                return maxEpair;
            }
            
            function getInnermostE(startE)  {
                var pair = findInnerElement(startE, 0);
                return pair.E;
            }
            
            function onclickLoader(evt) {
              evt = evt || Event;
                
                var element = evt.target;
                
                var innermostChild = getInnermostE(element);
                
                alert(innermostChild);
            }