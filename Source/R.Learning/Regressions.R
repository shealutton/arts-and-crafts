# Running regressions in R
# 1. Summarize and look for data problems. NA's, 0's, negative #'s, etc
# 2. Plot data to look for problems
# 3. 

library(datasets)
data(mtcars)
mtcars


# Look for data errors, exagerated or unbelieveable numbers and outliers
summary(mtcars)

hist(mtcars$hp) # bell curve ish
plot(sort(mtcars$hp),pch="-") # should be s-curve shaped with reasonable highs and lows
plot(density(mtcars$hp,na.rm=TRUE)) # bell curve ish

plot(mpg ~ cyl,mtcars)
plot(mpg ~ vs,mtcars)
pairs(mtcars) # a matrix of bivariate plots 

# scale normalizes all results to have a mean of 0 and a sd of 1
test <- scale(mtcars)
summary(test)
str(test)
plot(disp ~ hp, test)
abline(0,1)
# To use lm, must have data in a data.frame
x <- data.frame(disp = mtcars$disp, hp = mtcars$hp)
x
g <- lm(disp ~ hp, x)
g
abline(g$coef,lty=5)
cor(x)


