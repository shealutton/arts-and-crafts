#! /usr/bin/python

class UnionFind:
    """Union-find data structure.
    - X[item] returns a name for the set containing the given item.
      Each set is named by an arbitrarily-chosen one of its members; as
      long as the set remains unchanged it will keep the same name. If
      the item is not yet part of a set in X, a new singleton set is
      created for it.

    - X.union(item1, item2, ...) merges the sets containing each item
      into a single larger set.  If any item is not yet part of a set
      in X, it is added to X as one of the members of the merged set.
    """

    def __init__(self):
        """Create a new empty union-find structure."""
        self.weights = {}
        self.parents = {}

    def __getitem__(self, object):
        self.find(object)

    def find(self, object):
        """Find and return the name of the set containing the object."""
        # check for previously unknown object
        if object not in self.parents:
            self.parents[object] = object
            self.weights[object] = 1
            print "Weights: ", self.weights[object]
            return object

        # find path of objects leading to the root
        path = [object]
        root = self.parents[object]
        while root != path[-1]:
            path.append(root)
            root = self.parents[root]

        # compress the path and return
        for ancestor in path:
            self.parents[ancestor] = root
        return root
        
    def __iter__(self):
        """Iterate through all items ever found or unioned by this structure."""
        return iter(self.parents)

    def union(self, *objects):
        """Find the sets containing the objects and merge them all."""
        roots = [ self[x] for x in objects ]

        #heaviest = max([(self.weights[r],r) for r in roots])[1]
        for r in roots:
            print r
            #self.weights[r]
        for r in roots:
            pass
            #if r != heaviest:
                #self.weights[heaviest] += self.weights[r]
                #self.parents[r] = heaviest

x = 1
y = 2
U = UnionFind()
print U.find(x)
print U.find(y)
U.union(x,y)
for i in U:
   print i

print U.find(x)
print U.find(y)

