## Types of graphs
graphics # plot, hist, boxplot, etc
lattice # trellis graphs, xyplot, bwplot, levelplot
grid # lattice is based on grid, might not need grid by itself
grDevices # code for x11, pdf, png, postscript

### Package Install -> Install lattice -> Load lattice
library(lattice)

?par

# Things to consider: 
# paper or screen?
# Mac, win, or linux?
# lots of data or a few points?
# Need to resize it?

# Base graphics are constructed piecemeal, points, labels, lines, etc 
# ALL ELEMENTS ARE ADDITIVE
# Lattice/grid have to be constructed in one call

### Demo plots for examples
example(points) # demo plots

set.seed(1)
x <- rnorm(20)
y <- rnorm(20)
plot(x,y)
hist(x)

# Most functions for graphing are controlled through par. 
?par # the par help page, vars are global

pch = plot symbol (like open circle)
lty = line type
lwd = line width (int)
col = color
las = orientation of labels
bg = background color
mar = margin size
oma = outer margin
mfrow = number of plots per row 
mfcol = number of plots per col

### check the current values
par("lty")
par("mar")
# Values are clockwise from the bottom (x axis)
oma is generally only useful if you have more than one plot per canvas

plot() # scatterplot
lines() # add lines to a plot
points()# add points
text() # add text
title()
mtext() add arbitrary margin text 
axis()

# Save files for unix
xfig

par("pch")

# To copy a plot to a different device (devices are like pdf, png)
dev.copy
dev.copy2pdf 
dev.lines # show open devices
dev.next # move to the next device
dev.set # set current device
dev.off # close

### More sample graphs
set.seed(1)
x <- rnorm(100)
y <- rnorm(100)
plot(x,y)
hist(x)
plot(x,y, pch = 20)
plot(x,y, pch = 19)
plot(x,y, pch = 2)
plot(x,y, pch = 3, xlab = "Weight", ylab = "Height")
title("Scatterplot")
text(-1, -1, "Label")
legend("topleft", legend = "Data", pch = 20)

### Fitting a regression line
fit <- lm(y ~ x)
str(fit)
abline(fit, lmd = 3, col = "red")

#Another abline example, the x- and y-axis, and an integer grid
plot(c(-2,3), c(-1,5), type = "n", xlab="x", ylab="y", asp = 1)
abline(h=0, v=0, col = "gray60")

### Adding a third var
z <- rpois(100,2)
par(mfrow = c(2,1))
plot(x,y,pch = 20)
plot(x,y,pch = 4)

par(mar = c(2,2,1,1))
plot(x,y,pch = 20)
plot(x,y,pch = 4)

### Graphing with a factor
par(mfrow = c(1,1))
x <- rnorm(100)
y <- x + rnorm(100) # so it has some relationship, we add x
g <- gl(2,50, labels = c("Male", "Female"))
str(g)
plot(x,y) # you don't know who the guys are...
plot(x,y,type = "n") # Create the plot but skip the data 
### Then use points to add the data with certain params
points(x[g == "Male"], y[g == "Male"], col = "green")
points(x[g == "Female"], y[g == "Female"], col = "red")



#####
### LATTICE GRAPHS
#####

xyplot() #scatter
bwplot() # box and whiskers
histogram 
stripplot # boxplot but with points
dotplot # plot dots on violin strings
splom # scatterplot matrix, like pairs in base graphics system
levelplot, contourplot # for plotting image data 

# Lattice plots usually start with a formula
y ~ x | f * g
# y is on the left of the ~, x on the right. 
# the | is a conditioning variable
# the * is an interaction
# The second arg is often a data frame, where to locate the data

# Base functions plot directly to the graphics device
# Lattice functions return an object of class trellis without drawing it
# When you print a lattice function it creates the object. Auto-print can hide this behavior

x <- rnorm(100)
y <- x + rnorm(100, sd = 0.5)
f <- gl(2,50, labels = c("Group 1", "Group 2"))
xyplot(y ~ x | f)

# Create your own plot functions
xyplot(y ~ x | f, 
       panel = function(x, y, ...) {
         panel.xyplot(x,y, ...)
         panel.abline(h = median(y), lty = 2) # Calculate the median of y and plot it as a line
       }) # You have to use panel.abline, abline won't work like it does for base

xyplot(y ~ x | f, 
       panel = function(x, y, ...) {
         panel.xyplot(x, y, ...)
         panel.lmline(x, y, col = 2) # plot regression line
       })

### More lattice experiments
package ? lattice
library(help = lattice)
# notice that there are data sets built in!
data(environmental)
?environmental
head(environmental)
# Y ~ X, so ozone = y, rad = x
xyplot(ozone ~ radiation, data = environmental)
xyplot(ozone ~ radiation, data = environmental, main = "Ozone v. Radiation")
xyplot(ozone ~ temperature, data = environmental, )
# Lattice is good at multivariate plots
# What if you wanted to know if the relationship between ozone and rad change as the temp increases?
summary(environmental$temperature)
# Too many possible temps to use by itself, we need to condense/summarize the temp ranges
temp.cut <- equal.count(environmental$temperature, 4)
temp.cut # 4 ranges were created that slightly overlap. Called "shingles" because they overlap
xyplot(ozone ~ radiation | temp.cut, data = environmental)
# All 4 resulting plots are ozone ~ rad, but for different temp ranges. You can see that as temps increase
# that the ozone increases
xyplot(ozone ~ radiation | temp.cut, data = environmental, layout = c(1,4)) # change layout
xyplot(ozone ~ radiation | temp.cut, data = environmental, layout = c(1,4), as.table = TRUE) # reverse order
# What if we wanted to plot the relationship btween rad and ozone?
xyplot(ozone ~ radiation | temp.cut, data = environmental, layout = c(1,4), as.table = TRUE,pch = 20,
       panel = function(x,y, ...) {
         panel.xyplot(x, y, ...)
         fit <- lm(y ~ x)
         panel.abline(fit, lwd = 2) # Regression line, increases as the temp gets warmer
       })
# If you want a smooth line
xyplot(ozone ~ radiation | temp.cut, data = environmental, layout = c(1,4), as.table = TRUE,pch = 20,
       panel = function(x,y, ...) {
         panel.xyplot(x, y, ...)
         panel.loess(x, y)
       }, xlab = "Solar Radiation", ylab = "Ozone (ppb)", main = "Ozone v. Radiation")

# Using wind values too
wind.cut <- equal.count(environmental$wind, 4)
wind.cut
xyplot(ozone ~ radiation | temp.cut * wind.cut, data = environmental, as.table = TRUE, pch = 20,
       panel = function(x,y, ...) {
         panel.xyplot(x, y, ...)
         panel.loess(x, y)
       }, xlab = "Solar Radiation", ylab = "Ozone (ppb)", main = "Ozone v. Radiation")

### SPLOM
# graph all metrics in a data frame
splom(~ environmental)
histogram( ~ temperature, data = environmental)
histogram( ~ temperature | wind.cut, data = environmental)
histogram( ~ ozone | wind.cut, data = environmental)
histogram( ~ ozone | temp.cut * wind.cut, data = environmental)


### Adding greek letters/mathmatical symbols to graphs using LATEX formatting
?plotmath
expression() 

plot(0,0, main = expression(theta == 0),
    ylab = expression(hat(gamma) == 0),
    xlab = expression(sum(x[i] * y[i], i==1, n))
)

# Pasting strings together with math labels (full text inside expression() function)
x <- rnorm(100)
hist(x, xlab = expression("The mean ("* bar(x) * ") is " *
  sum(x[i]/n,i==1,n)))

# Calculating labels on the fly with substitute() function
x <- rnorm(100)
y <- x + rnorm(100, sd = 0.5)
plot(x, y, 
  xlab = substitute(bar(x) == k, list(k=mean(x))),
  ylab = substitute(bar(y) == k, list(k=mean(y)))
)

# A for loop for labels, Theta = 1:4
par(mfrow = c(2,2))
for( i in 1:4 ) {
  x <- rnorm(100)
  hist(x, main=substitute(theta==num,list(num=i)))
}

?par
?plot
?xyplot
?plotmath
?axis

#grDevices
colorRamp() # take a palette and return a map (0-1) to indicate extremes in color 
colorRampPalette() # take a palette and return a vector of colors like a gradient
# take a palette of colors and interpolates other colors between them
colors()
gray()

pal <- colorRamp(c("red", "blue"))
pal(0) # gives RGB values back, 0 = red
pal(1) # 1 = blue
pal(.5) # 1/2 red, 1/2 blue

pal(seq(0, 1, len = 10))

pal <- colorRampPalette(c("red", "yellow"))
pal(2)
pal(10)

# RColorBrewer package has prebuilt color palettes from CRAN
# sequential - for ordered data
# divergent - for data that moves away from a mean (two tails)
# qualitative - factors or data that has no order
library(RColorBrewer)
cols <- brewer.pal(3, "BuGn")
pal <- colorRampPalette(cols)
image(volcano, col = pal(20))

# Plotting a scatter plot with a lot of points
# Smooth scatter creates a density map like a 2d histogram 
x<- rnorm(10000)
y <- rnorm(10000)
smoothScatter(x, y)

# More color details
rgb() # way to calculate colors in hex? from rgb vals
# use the alpha channel to create transparencies in rgb
plot(x,y, col = rgb(0,0,0,0.2), pch=19)

colorspace()

















